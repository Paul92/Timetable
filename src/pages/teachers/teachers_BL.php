<?php

/**
 * Teachers module. It handles teacher addition, deletion and teacher to 
 * subject relations.
 */

/**
 * Constants:
 */
require_once(DATABASE_MODULE);

$DB = connect();

if (isset($_POST['submit'])) {
    $query = "INSERT INTO teachers (teacherName) VALUES ('".$_POST['newTeacher']."')";
    mysqli_query($DB, $query);
}

if (isset($_POST['deleteTeacher'])) {
    foreach ($_POST['deleteTeacher'] as $deleteTeacher) {
        $query = "DELETE FROM teachersToSubject WHERE teacherId=";
        $query.= $deleteTeacher.";";
        mysqli_query($DB, $query);
        $query = "DELETE FROM teachers WHERE teacherId=".$deleteTeacher.";";
        mysqli_query($DB, $query);
    }
}

if (isset($_POST['remove'])) {
    $exploded = explode(',', $_POST['remove']);
    $remove = array();
    foreach ($exploded as $value) {
        $temp = explode(':',$value);
        $remove[$temp[0]] = $temp[1];
    }

    $teacherId = $remove['teacherId'];
    $subjectId = $remove['subjectId'];
    $query = "DELETE FROM teachersToSubject WHERE subjectId=";
    $query.= $subjectId." AND teacherId=".$teacherId.";";
    mysqli_query($DB, $query);
}

$teachers = mysqli_query($DB, "SELECT * FROM teachers");

$data['teachers'] = mysqli_fetch_all($teachers, MYSQLI_ASSOC);
foreach ($data['teachers'] as $teacher) {
    $query = "SELECT * FROM teachersToSubject WHERE teacherId=";
    $query.= $teacher['teacherId'].';';
    $subjectsTaught = mysqli_query($DB, $query);
    $data[$teacher['teacherId']] = array();
    while ($subjectTaught = mysqli_fetch_array($subjectsTaught)) {
        $query = "SELECT * FROM subjects WHERE subjectId=";
        $query.= $subjectTaught['subjectId'];
        $data[$teacher['teacherId']][] = mysqli_query($DB, $query);
    }
}

return $data;
