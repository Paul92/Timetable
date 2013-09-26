<?php
/**
 * Courses module. It handles course viewing and addition
 */

/**
 * Constants:
 */

require_once(DATABASE_MODULE);

$DB = connect();

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

/**
 * Variable for holding table courses
 */
$courses = mysqli_query($DB, "SELECT * FROM courses");

