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
 * int countScheduleSlots(mixed $db)
 *
 * @param mixed $db - mysqli object that represents database connection
 *
 * @return int slots - number of slots available in a week's schedule
 */
function countScheduleSlots($db){

    $slotSize = 1; //Hardcoded

    $query = "SELECT SUM(endHour - startHour) FROM schedule;";
    $query = mysqli_query($db, $query);
    $query = mysqli_fetch_array($query);
    $query = $query[0] / 10000; //Needs more thinking

    return $query / $slotSize;
}

/**
 * int countSubjectSlots(mixed $db)
 *
 * @param mixed $db - mysqli object that represents database connection
 *
 * @return int slots - number of subject slots available in a week
 */
function countSubjectSlots($db){
    $query = "SELECT SUM(hours) FROM subjects;";
    $query = mysqli_query($db, $query);
    $query = mysqli_fetch_array($query);
    return $query[0];
}



/**
 * mixed generate_individual(mixed $data)
 *
 * @param mixed $db - mysqli object that represents database connection
 *
 * @return mixed timetable - returns a randomly generated timetable, as 
 *                           documented at the beginning of this file
 */
function generate($db) {

    $timetable = array();
    $query = "SELECT * FROM subjects;";
    $query = mysqli_query($db, $query);

    while($arr = mysqli_fetch_array($query)){
        while($arr['hours']--){
            $timetable[] = (int)$arr['subjectId'];
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
    $slotSize = 1; //Hardcoded
    $i = 0;
    $today = 0;
    $ret = array('hard' => 0, 'soft' => 0);

    $query = "SELECT (endHour - startHour)/(10000 * $slotSize) AS slots FROM schedule;";
    $query = mysqli_query($db, $query);

    while($todaySlots = (int)mysqli_fetch_array($query)['slots']){
        unset($todayTeachers);
        $todayTeachers = array();
        for($j = 0; $j < $todaySlots; $j++, $i++){
            $currentSubject = $individual[$i];

            $teacherQuery = "SELECT teacherId FROM teachersToSubject ";
            $teacherQuery.= "WHERE subjectId = $currentSubject;";
            $teacherQuery = mysqli_query($db, $teacherQuery);

            $teacherId = (int)mysqli_fetch_array($teacherQuery)['teacherId'];

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

    $query = "SELECT (endHour - startHour)/(10000 * $slotSize) AS slots FROM schedule;";
    $query = mysqli_query($db, $query);

    while($todaySlots = (int)mysqli_fetch_array($query)['slots']){
        $todaySubjects = array();
        for($j = 0; $j < $todaySlots; $j++, $i++){
            $currentSubjectId = $individual[$i];
            $currentSubjectName = "SELECT subjectName FROM subjects ";
            $currentSubjectName.= "WHERE subjectId = $currentSubjectId;";
            $currentSubjectName = mysqli_query($db, $currentSubjectName);
            $currentSubjectName = mysqli_fetch_array($currentSubjectName);
            $currentSubjectName = $currentSubjectName['subjectName'];

            $todaySubjects[] = $currentSubjectName;
        }
        $ret[] = $todaySubjects;
    }
 
    return $ret;
}


