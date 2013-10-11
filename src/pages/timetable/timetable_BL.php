<?php
/**
 * Timetable generator module
 * This submodule deals with database fetching, data checking and calls 
 * genenerateTimetable function
 */

/**
 * Database fetching
 *
 * This stage is supposed to fetch data from database and put it in 
 * a normalized structure that will be used to generate the timetable.
 *
 * $data = array(
 *       $subjects = array(subject1, subject2, ..., subjectn),
 *       $noOfSlots = array(noOfSlots_subject1, ..., noOfSlots_subjectn);
 *       $teachers = array(teacher1, teacher2, ..., teachern),
 *       $teacherPreference = array(preference_teacher1, ..., 
 *                                  preference_teachern),
 *       $daySlots = array(mondaySlots, ..., fridaySlots),
 *       bool $correlativeHours,
 * );
 *
 * $subjects holds subjects IDs (not subject names). For each $subjects[i]
 * exists a noOfSlots[i], which represent numberOfHours that subject[i] has
 * per week, and a teacher[i], which represent teacher needed for subject[i].
 * Also, teacher1, ..., teachern are teacher IDs.
 *
 * $teacherPreference is a code (0, 1 or 2) that represents the teacher 
 * preference. 
 *      0 - between 8 and 12
 *      1 - between 12 and 16
 *      2 - between 16 and 20
 *  Note: teacher preferences are soft constrains, i.e. they may not be 
 *  fulfilled (they may not be fesable ethier).
 *
 * $daySlots represent number of slots in a certain day. Note that I use slots, 
 * not hours, because a day may be divided in slots of 2 hours each, for 
 * example.
 *
 * $correlativeHours is a boolean value that represent if classes should be 
 * correlative or not.
 *
 * All values are required (i.e. they must be defined) and data must be checked
 * before proceeding
 *
 */

require_once(DATABASE_MODULE);
$DB = connect();

$data = array(
    'subjects'          => array(),
    'noOfSlots'         => array(),
    'teachers'          => array(),
    'teacherPreference' => array(),
    'daySlots'          => array(),
    'correlativeHours'  => FALSE,
);
$errors = array();

//Subject fetching
$query = 'SELECT subjectId, hours FROM subjects;';
$subjects = mysqli_query($DB, $query);
while ($subject = mysqli_fetch_array($subjects)) {
    $data['subjects'][]  = (int)$subject['subjectId'];
    $data['noOfSlots'][] = (int)$subject['hours'];
}

if (empty($data['subjects'])) {
    $errors[] = 'No subjects';
}


//Teacher fetching
foreach ($data['subjects'] as $subjectId) {
    $query = 'SELECT teacherId FROM teachersToSubject WHERE subjectId ="';
    $query.= $subjectId . '";';

    $teachers = mysqli_query($DB, $query);
    $subjectTeachers = array();
    while ($teacher = mysqli_fetch_array($teachers)) {
        $subjectTeachers[] = $teacher['teacherId'];
    }

    if (empty($subjectTeachers)) {
        $errors[] = 'Subject ' . $subjectId . ' has no teachers';
    }
    $data['teachers'][] = $subjectTeachers;
}

//Schedule fetching
$query = 'SELECT * FROM schedule;';
$schedule = mysqli_query($DB, $query);

//TODO: A slot may be longer than an hour
while ($day = mysqli_fetch_array($schedule)) {
    sscanf($day['startHour'], "%d", $startH);
    sscanf($day['endHour'], "%d", $endH);

    $data['daySlots'][] = $endH - $startH;
}

//TODO: Correlative hours



//Pass data to VL
if (isset($errors)) {
    return $errors;
} else {
    return "PLACEHOLDER";
}



