<?php
/**
 * Submodule for course addition. It handles addition form and database
 * update
 */
if(isset($_POST['subjectName'])){
    $query = "INSERT INTO subjects (subjectName, courseId) VALUES (";
    $query.= $_POST['subjectName']." ,".$_POST['courseId'];
    $DB = connect();
    mysqli_query($DB, $query);
}


if(isset($_GET['courseName'])){
    echo "<form method='GET'>\n";
    echo "<p>Add a subject to ".$_GET['courseName']." course</p>\n";
    echo "<form>\n";
    echo "<label for='subjectName'>Subject Name: </label>\n";
    echo "<input type='hidden' name='courseId' value='".$_GET['courseId']."/>\n";
    echo "<input type='text' id='subjectName' name='subjectName' />\n";
    echo "<input type='submit' name='submit' value='Submit' />\n";
    echo "</form>";
}else{
    echo "ERROR: CourseName not set\n";
}
