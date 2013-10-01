<?php
/**
 * Submodule for addition teachers to a course. It handles addition form and database
 * update
 */

require_once(DATABASE_MODULE);
$DB = connect();

$data = array();

$data['teachers'] = mysqli_query($DB, "SELECT * FROM teachers");
$data['teachers'] = mysqli_fetch_all($data['teachers'], MYSQLI_ASSOC);

$data['taughtBy'] = array();
$query = "SELECT * FROM teachersToSubject WHERE subjectId=";
$query.= $_GET['subjectId'].";";
$teachers = mysqli_query($DB, $query);
while ($teaches = mysqli_fetch_array($teachers)) {
    $data['taughtBy'][] = $teaches['teacherId'];
}

$query = "SELECT * FROM subjects WHERE subjectId=".$_GET['subjectId'];
$subject = mysqli_query($DB, $query);
$subject = mysqli_fetch_array($subject);
$data['subjectName'] = $subject['subjectName'];
$data['subjectId']   = $subject['subjectId'];
$data['hours'] = $subject['hours'];

if (isset($_POST['submit']) && isset($_POST['subjectId'])) {
    $query = "DELETE FROM teachersToSubject WHERE subjectId=";
    $query.= $subject['subjectId'].";";
    mysqli_query($DB, $query);
    if (isset($_POST['teachers'])) {
        foreach ($_POST['teachers'] as $teacher) {
            $query = 'INSERT INTO teachersToSubject (subjectId, teacherId) VALUES (';
            $query.= $_POST['subjectId'].', '.$teacher.');';
            mysqli_query($DB, $query);
        }
    }
    header('Location: ?show=courses');
}

return $data;
