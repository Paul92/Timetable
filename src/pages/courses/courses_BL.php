<?php
/**
 * Courses module. It handles course viewing and addition
 */

/**
 * Constants:
 */

//database connection
require_once(DATABASE_MODULE);
$DB = connect();

/**
 * Data passed to VL
 */
$data = array();

if (isset($_POST['submit'])) {
    $query = "INSERT INTO courses (courseName) VALUES ('".$_POST['newCourse']."')";
    mysqli_query($DB, $query);
}

if (isset($_POST['delete'])) {
    $query = "DELETE FROM teachersToSubject WHERE subjectId=".$_POST['delete'][0].";";
    mysqli_query($DB, $query);
    $query = "DELETE FROM subjects WHERE subjectId=".$_POST['delete'][0].";";
    mysqli_query($DB, $query);
}

if (isset($_POST['deleteCourse'])) {
    foreach ($_POST['deleteCourse'] as $deleteCourse) {
        $subjects = mysqli_query($DB, "SELECT subjectId FROM subjects WHERE courseId=".$deleteCourse.';');
        while ($subject = mysqli_fetch_array($subjects)) {
            $query = "DELETE FROM teachersToSubject WHERE=".$subject['subjectId'].";";
            mysqli_query($DB, $query);
            $query = "DELETE FROM subjects WHERE subjectId=".$subject['subjectId'].";";
            mysqli_query($DB, $query);
        }
        mysqli_query($DB, "DELETE FROM courses WHERE courseId=".$deleteCourse.";");
    }
}

//$data['courses'] contains an associative array with course data, generated
//by mysqli_fetch_all.
//$data[i] contains a mysqli_result object that represents the subject data
//for course i
$courses = mysqli_query($DB, "SELECT * FROM courses");

$data['courses'] = mysqli_fetch_all($courses, MYSQLI_ASSOC);
foreach($data['courses'] as $course){
    $query  = "SELECT * FROM subjects WHERE courseId=".$course['courseId'];
    $result = mysqli_query($DB, $query);
    $data[$course['courseId']] = $result;
}

//return to controller
return $data;
