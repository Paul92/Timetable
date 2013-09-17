<?php

if(isset($_POST['submit'])){
    $query = "INSERT INTO courses (courseName) VALUES ('".$_POST['newCourse']."')";
    mysqli_query($DB, $query);
}

$courses = mysqli_query($DB, "SELECT * FROM courses");

