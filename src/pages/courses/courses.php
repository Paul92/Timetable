<?php include 'BL.php'; ?>

<form method="POST">

<table>

<?php
while($course = mysqli_fetch_array($courses)){
    echo "<tr>\n";
    echo "<td> Course ".$course['courseId'].': <a href="pages/courses/addSubject.php?courseName='.$course['courseName'];
    echo '&courseId='.$course['courseId'].'>'.$course['courseName']."</a></td>\n";
    $subjects = mysqli_query($DB, "SELECT id FROM subjects WHERE courseID='".$course['courseId']."'");
    if(/*mysqli_num_rows*/($subjects)){
        echo "<table>\n";
        while($subject = mysqli_fetch_array($subjects)){
            echo "<tr>";
            echo "<td>".$subject['subjectName'].'</td>';
            echo "</tr>\n";
        }
    }
    echo "</tr>\n";
}
?>

</table>


<label for="newCourse"> Add new course: </label>
<input type="text" id="newCourse" name="newCourse" />
<input type="submit" name="submit" value="Submit"/>

</form>
