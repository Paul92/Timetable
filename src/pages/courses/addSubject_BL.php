<?php
/**
 * Submodule for course addition. It handles addition form and database
 * update
 */

require_once(DATABASE_MODULE);
$DB = connect();

$data = array();

$query = "SELECT courseName FROM courses WHERE courseId=".$_GET['courseId'];
$courseName = mysqli_query($DB, $query);
$courseName = mysqli_fetch_array($courseName)['courseName'];
$data['courseName'] = $courseName;

$data['teachers'] = mysqli_query($DB, "SELECT * FROM teachers");

if (isset($_POST['subjectName']) && isset($_POST['teachers'])) {
    $query = 'INSERT INTO subjects (subjectName, courseId) VALUES ("';
    $query.= $_POST['subjectName'].'", '.$_POST['courseId'].');';
    $DB = connect();
    mysqli_query($DB, $query);
    $subjectId = mysqli_insert_id($DB);
    foreach ($_POST['teachers'] as $teacherId) {
        $query = 'INSERT INTO teachersToSubject (subjectId, teacherId) VALUES (';
        $query.= $subjectId.', '.$teacherId.');';
        mysqli_query($DB, $query);
    }
    header('Location: ?show=courses');
}

return $data;

