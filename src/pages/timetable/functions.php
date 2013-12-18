<?php
/**
 * This module helper contains functions needed for timetable generation. 
 * The algorithm used is a genetic algoritm. There are few steps required:
 *
 * 1. First generation
 * - it is a random generation of a timetable
 * - in order to accomplish this, $data[$subjects] array should be iterated,
 * find a empty slot (random) and put the subject in that slot
 * - if the random slot is not empty, it should search for the NEAREST empty
 * slot (a linear search will do).
 *
 * 2. After first generation, the evolving process should start. This is 
 *    accomplished by 3 genetic operations:
 *    - reproduction
 *    - crossover
 *    - mutation
 *
 * 2.1. Reproduction
 *    - is just a copy of an individual
 *
 * 2.2. Crossover
 *    - take 2 individuals that are going to reproduce
 *    - select a random crossover point, spliting individuals A and B into 4
 *      parts: A1, A2, B1, B2
 *    - crossover them
 *    - the 2 new individuals will look like this: A1B2, B1A2
 *
 * 2.3. Mutation
 *    - randomly change an individual's attribute
 *
 * 3. Fitness
 *    - every time an individual is created, it's fitness should be evaluated
 *    - fitness is a mark given to a certain individual that represents how
 *    good is it, i.e. how many constraints it satisfies
 *    - there are 2 types of constraints: hard ones and soft ones. Hard ones
 *    MUST be satisfied. Soft ones (like teacher preferences) should be 
 *    satisfied, if possible
 *    - depending on how many constraints an individual satisfies, a mark is
 *    given to it.
 *    - "mark" is a compound structure (a, b). a represents number of hard 
 *    constraints that are NOT satisfied, and b represents number of soft
 *    constraints that are NOT satisfied.
 *    - an ideal individual has mark (0, 0), but this may ethier be not fesable
 *    or would require too much resources to compute
 *    - an acceptable individual has mark (0, x), where x should be as small as 
 *    possible. 
 *
 * NOTES:
 *    - after an evolution step (2.2, 2.3), the new individual should not be 
 *    added to individual's list if it has a smaller mark
 *
 * The evolving process should stop when an acceptable individual is found.
 *
 * The timetable data structure:
 *
 * $timetable = array(slot1, slot2, ..., slotn);
 *  , where slot1, ..., slotn represents the subject ID taken in that slot.
 *  the first k slots represents monday slots, where k is the number of slots
 *  from monday. Simillar for other days. The size of $timetable MUST be equal
 *  with the number of slots in a week.
 *
 * A generation is a array of timetables, each one being an individual.
 * $generation = array($individual1, ..., $individualn),
 * where $individualk is a timetable
 */


/**
 * The fitness threshold. For any fitness lower than this, the individual is
 * accepted.
 */
const FITNESS_THRESHOLD_HARD = 0;
const FITNESS_THRESHOLD_SOFT = 3;

/**
 * The mutation probability is 1 in MUTATION_RATE individuals
 */
const MUTATION_RATE = 3;


/**
 * int countSubjectSlots(mixed $db)
 *
 * @param mixed $db - mysqli object that represents database connection
 *
 * @return int slots - number of subject slots available in a week
 */
function countSubjectSlots($db){
    $query = "SELECT SUM(hours) FROM subjects;";
    $SQL   = mysqli_query($db, $query);
    $row   = mysqli_fetch_array($SQL);
    return $row[0];
}


/**
 * int averageSlots(mixed $db)
 *
 * @param mixed $db - mysqli object that represents database connection
 *
 * @return int slots - average subject slots a day
 */
function averageSlots($db){
    $query = "SELECT SUM(hours) as totalSlots FROM subjects;";
    $SQL   = mysqli_query($db, $query);
    $row   = mysqli_fetch_array($SQL);
    $noOfSlots = $row['totalSlots'];

    $daySlots = array(); //implement forbidden days
    $noOfDays = 5;

    $average = (int)($noOfSlots/$noOfDays);
    $rest    = $noOfSlots - $average * $noOfDays;
    for($i = 0; $i < $noOfDays; $i++){
        $daySlots[$i] = $average;
        if($rest){
            $daySlots[$i]++;
            $rest--;
        }
    }

    shuffle($daySlots);
    return $daySlots;
}


/**
 * void swap(int &a, int &b)
 *
 * Function swaps 2 variables, by passing them as a reference
 *
 * @param int& a 
 * @param int& b
 *
 * @return void
 */
function swap(&$a, &$b){
    $temp = $a;
    $a = $b;
    $b = $temp;
}


/**
 * mixed generate(mixed $data)
 *
 * @param mixed $db - mysqli object that represents database connection
 *
 * @return mixed timetable - returns a randomly generated timetable, as 
 *                           documented at the beginning of this file
 */
function generate($db) {

    $timetable = array();
    $query     = "SELECT * FROM subjects;";
    $SQL       = mysqli_query($db, $query);

    while($row = mysqli_fetch_array($SQL)){
        while($row['hours']--){
            $timetable[] = (int)$row['subjectId'];
        }
    }

    shuffle($timetable);

    return $timetable;
}


/**
 * mixed generate_generation(mixed $data, int $generationSize)
 *
 * @param mixed $db - mysqli object that represents database connection
 * @param int $generationSize - generation size
 *
 * @return mixed generation - returns a randomly generated generation, with
 *                            generationSize individuals, as documented at
 *                            the beginning of this file
 */
function generate_generation($db, $generationSize) {

    $generation = array();
    for ($i = 0; $i < $generationSize; $i++) {
        $generation[] = generate($db);
    }

    return $generation;

}


/**
 * mixed fitness(mixed $db, mixed $individual)
 *
 * @param mixed $db - mysqli object that represents database connection
 * @param mixed $individual - the individual for which to compute the fitness
 *                            value
 *
 * @return mixed mark - a mark that shows how good it a certain individual
 *
 *
 *      This function is the most important function for the timetable 
 *      generation algoritm. It's efficency and corectness is reflected in
 *      the result. 
 *      The mark is a data structure that evaluates the quality of an 
 *      individual.
 *      $mark = array(int, int), where mark['hard'] is the number of hard 
 *      constraints not satisfied and mark['soft'] is the number of soft 
 *      constraints not satisfied.
 *      Currently, this functions checks for following constraints:
 *          - a teacher MUST NOT have pauses in a day, i.e. his teaching hours 
 *          must be continuous
 *          - a teacher SHOULD teach in the preferred moment of day
 *
 * TODO: implement soft constraints
 */

function fitness($db, $individual){
    $slotSize = getSlotSize();
    $ret = array('hard' => 0, 'soft' => 0);
    $days = averageSlots($db);
    $noOfDays = count($days);
    $i = 0;

    for($today = 0; $today < $noOfDays; $today++){
        unset($todayTeachers);
        $todayTeachers = array();
        for($j = 0; $j < $days[$today]; $j++, $i++){
            $currentSubject = $individual[$i];

            $teacherQuery = "SELECT teacherId FROM teachersToSubject ";
            $teacherQuery.= "WHERE subjectId = $currentSubject;";
            $teacherSQL   = mysqli_query($db, $teacherQuery);
            $teacherIdArray = mysqli_fetch_array($teacherSQL);
            $teacherId = (int)$teacherIdArray['teacherId'];

            if(isset($todayTeachers[$teacherId]) && 
              ($j > 0 && $lastTeacher != $teacherId)){ 
                $ret['hard']++;
            }
            $lastTeacher = $teacherId;
            $todayTeachers[$teacherId] = TRUE;
        }
    }

    return $ret;
}

/**
 * string computeStartHour(mixed $db, int $day, int $slot)
 *
 * @param mixed $db - mysqli object that represents database connection
 * @param int $day  - day id
 * @param int $slot - slot number in $day day
 *
 * @return string time - the time of start
 */
function computeStartHour($db, $day, $slot){

    $timeQuery = "SELECT ADDTIME(startHour, ";
    $timeQuery.= "SEC_TO_TIME(TIME_TO_SEC(slotLength) * $slot)) ";
    $timeQuery.= "AS time FROM schedule, slotSize WHERE dayId=$day;";
    $timeSQL   = mysqli_query($db, $timeQuery);
    $time      = mysqli_fetch_array($timeSQL)['time'];

    return $time;
}


/**
 * mixed parse(mixed $generation)
 *
 * @param mixed $db - mysqli object that represents database connection
 * @param mixed $individual - an array that represents a generation
 *
 * @return mixed ret - an array that matches course names and slots for output
 */
function parse($db, $individual){
    $slotSize = 1; //Hardcoded
    $i = 0;
    $today = 0;
    $ret = array();

    $weekSlots = averageSlots($db);

    foreach($weekSlots as $todayId => $todaySlots){
        $todaySubjects = array();
        for($j = 0; $j < $todaySlots; $j++, $i++){
            $currentSubjectId    = $individual[$i];
            $currentSubjectQuery = "SELECT subjectName FROM subjects ";
            $currentSubjectQuery.= "WHERE subjectId = $currentSubjectId;";
            $currentSubjectSQL   = mysqli_query($db, $currentSubjectQuery);
            $currentSubjectRow   = mysqli_fetch_array($currentSubjectSQL);
            $currentSubjectName  = $currentSubjectRow['subjectName'];

            $currentTeacherQuery = "SELECT teacherName FROM teachers ";
            $currentTeacherQuery.= "WHERE teacherId = (";
            $currentTeacherQuery.= "SELECT teacherId FROM teachersToSubject ";
            $currentTeacherQuery.= "WHERE subjectId = $currentSubjectId);";
            $currentTeacherSQL   = mysqli_query($db, $currentTeacherQuery);
            $currentTeacherRow   = mysqli_fetch_array($currentTeacherSQL);
            $currentTeacherName  = $currentTeacherRow['teacherName'];

            $course = array();

            $course['startHour'] = computeStartHour($db, $todayId, $j);
            $course['endHour']   = "";
            $course['teacher']   = $currentTeacherName;
            $course['subject']   = $currentSubjectName;

            $todaySubjects[]     = $course;
        }
        $ret[] = $todaySubjects;
    }


    return $ret;
}

/**
 * mixed crossover(mixed $individual_A, mixed $individual_B)
 * 
 * NOTE: this function assumes that $individual_A and $individual_B sizes are the same!
 *       undefined behaviour otherwise
 * 
 * @param mixed $individual_A - an individual implied in crossover
 * @param mixed $individual_A - an individual implied in crossover
 *
 * @return mixed $child - the result of the crossver operation between 
 *                        $individual_A and $individual_B
 */
function crossover($individual_A, $individual_B){

    $individualSize = count($individual_A);
    $crossPoint = rand(1, $individualSize - 1);

    $child = array_slice($individual_A, 0, $crossPoint);
    $needed = array_slice($individual_A, $crossPoint);

    foreach($individual_B as $gene){
        if(($key = array_search($gene, $needed)) !== FALSE){
            $child[] = $gene;
            $needed[$key] = -1; //we do not need this subject anymore
                                //-1 is a dummy (there can not be a subject
                                //with id -1)
        }
    }

    return $child;
}


/**
 * mixed mutate(mixed $individual)
 *
 * This function may (under some probabilty) perform a mutation to an 
 * individual. This mutation consists in swapping 2 random subjects.
 *
 * @param mixed $individual - individual to mutate
 *
 * @return mixed $individual - individual recived as a parameter with a mutation
 */
function mutate($individual){
    if(1 == rand(0, MUTATION_RATE)){
        $individualSize = count($individual);
        $a = rand(0, $individualSize - 1);
        $b = rand(0, $individualSize - 1);
        swap($individual[$a], $individual[$b]);
    }
    return $individual;
}


/**
 * bool accepted(mixed $fitness)
 *
 * @param mixed $fitness - an individual's fitness, as returned by the fitness
 *                        function
 *
 * @return bool $accept  - returns wheter it is an acceptable fitness
 */
function accepted($fitness){
    if($fitness['hard'] <= FITNESS_THRESHOLD_HARD and
       $fitness['soft'] <= FITNESS_THRESHOLD_SOFT){
           return TRUE;
    }
    return FALSE;
}

/**
 * bool fitness_compare(mixed $a, mixed $b)
 *
 * @param mixed $a - fitness a to compare
 * @param mixed $b - fitness b to compare
 *
 * @return bool $better - return whether a is better than b or not
 *                        note that the hard constraint is evaluated first and
 *                        it is more important that the soft one.
 */
function fitness_compare($a, $b){
    if($a['hard'] < $b['hard'])
        return TRUE;
    else if($a['hard'] == $b['hard'] && $a['soft'] < $b['soft'])
        return TRUE;
    return FALSE;
}

/**
 * bool comp($a, $b)
 *
 * @param mixed $a - array($individual, $fitness)
 * @param mixed $b - array($individual, $fitness)
 *
 * @return bool result - checks if $a fitness is greater than $b fitness.
 *                       Used for sorting.
 */
function comp($a, $b){
    return !fitness_compare($a['fitness'], $b['fitness']);
}
