<?php

/**
 * Teachers module. It handles teacher addition, deletion and teacher to 
 * subject relations.
 */

/**
 * Constants:
 */

if (!file_exists(DATABASE_MODULE) || !is_readable(DATABASE_MODULE)) {
    exit(DATABASE_MODULE_NOT_FOUND);
}
require_once(DATABASE_MODULE);

$DB = connect();

if (isset($_POST['submit'])) {
    $query = "INSERT INTO teachers (teacherName) VALUES ('".$_POST['newTeacher']."')";
    mysqli_query($DB, $query);
}

if (isset($_POST['deleteTeacher'])) {
    foreach ($_POST['deleteTeacher'] as $deleteTeacher) {
        $query = "DELETE FROM teachersToSubject WHERE teacherId=".$deleteTeacher.";";
        mysqli_query($DB, $query);
        $query = "DELETE FROM teachers WHERE teacherId=".$deleteTeacher.";";
        mysqli_query($DB, $query);
    }
}

if (isset($_POST['removeSubject'])) {
    foreach ($_POST['removeSubject'] as $removeSubject) {
        $query = "DELETE FROM teachersToSubject WHERE subjectId=".$removeSubject.";";
        mysqli_query($DB, $query);
    }
}

$teachers = mysqli_query($DB, "SELECT * FROM teachers");
