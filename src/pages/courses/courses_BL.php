<?php

if(!file_exists('database.php') || !is_readable('database.php')){
    exit(DATABASE_MODULE_NOT_FOUND);
}

require_once('database.php');

$DB = connect();

if(isset($_POST['submit'])){
    $query = "INSERT INTO courses (courseName) VALUES ('".$_POST['newCourse']."')";
    mysqli_query($DB, $query);
}

$courses = mysqli_query($DB, "SELECT * FROM courses");

