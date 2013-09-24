<?php
/**
 * Submodule for addition teachers to a course. It handles addition form and database
 * update
 */
if(isset($_GET['teacherId']) && isset($_GET['subjectId'])){
    $query = 'INSERT INTO teachersToSubject (subjectId, teacherId) VALUES (';
    $query.= $_GET['subjectId'].', '.$_GET['teacherId'].');';
    $DB = connect();
    echo $query;
    mysqli_query($DB, $query);
    header('Location: ?show=courses');
}


if(isset($_GET['subjectName'])){
    echo "<p>Add a teacher to ".$_GET['subjectName']." subject</p>\n";
    echo "<p>Available teachers</p>";
    echo '<table>';
    $teachers = mysqli_query($DB, "SELECT * FROM teachers");
    while($teacher = mysqli_fetch_array($teachers)){
        echo '<tr><td><a href="?show=addTeacher&amp;subjectId=', $_GET['subjectId'];
        echo '&amp;teacherId=', $teacher['teacherId'], '">', $teacher['teacherName'];
        echo '</a></td></tr>';
    }
    echo '</table>';
}else{
    echo "ERROR: CourseName not set\n";
}
