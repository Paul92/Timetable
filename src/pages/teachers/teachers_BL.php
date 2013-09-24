<?php

/**
 * Teachers module. It handles teacher addition, deletion and teacher to 
 * subject relations.
 */

/**
 * Constants:
 */

if(isset($_POST['submit'])){
    $query = "INSERT INTO teachers (teacherName) VALUES ('".$_POST['newTeacher']."')";
    mysqli_query($DB, $query);
}

$teachers = mysqli_query($DB, "SELECT * FROM teachers");
