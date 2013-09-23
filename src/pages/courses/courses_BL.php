<?php
/**
 * Courses module. It handles course viewing and addition
 */

/**
 * Constants:
 */

if(isset($_POST['submit'])){
    $query = "INSERT INTO courses (courseName) VALUES ('".$_POST['newCourse']."')";
    mysqli_query($DB, $query);
}

if(isset($_POST['delete'])){
    $query = "DELETE FROM subjects WHERE subjectName='".$_POST['delete'][0]."';";
    mysqli_query($DB, $query);
}

/**
 * Variable for holding table courses
 */
$courses = mysqli_query($DB, "SELECT * FROM courses");

