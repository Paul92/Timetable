<?php
/**
 * Submodule for addition teachers to a course. It handles addition form and database
 * update
 */

require_once(DATABASE_MODULE);
$DB = connect();

$data = array();

$data['teachers'] = mysqli_query($DB, "SELECT * FROM teachers");

$query = "SELECT * FROM subjects WHERE subjectId=".$_GET['subjectId'];
$subject = mysqli_query($DB, $query);
$subject = mysqli_fetch_array($subject);
$data['subjectName'] = $subject['subjectName'];
$data['hours'] = $subject['hours'];
$data['subjectId'] = $_GET['subjectId'];

if (isset($_POST['submit']) && isset($_POST['subjectId'])) {
    foreach($_POST['teachers'] as $teacher){
        $query = 'INSERT INTO teachersToSubject (subjectId, teacherId) VALUES (';
        $query.= $_POST['subjectId'].', '.$teacher.');';
    }
    mysqli_query($DB, $query);
    header('Location: ?show=courses');
}

return $data;
