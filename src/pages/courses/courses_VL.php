<?php include 'courses_BL.php'; ?>

<form method="POST">

<table>

<?php
while($course = mysqli_fetch_array($courses)){
    echo "<tr>\n";
    echo '<td> Course ', $course['courseId'], ': <a href="?show=addSubject&amp;courseName=', $course['courseName'];
    echo '&amp;courseId=', $course['courseId'], '">', $course['courseName'], "</a></td></tr>\n";
    $subjects = mysqli_query($DB, "SELECT subjectName FROM subjects WHERE courseId='".$course['courseId']."'");
    if($subjects){
        echo "<tr><td><table style='margin-left: 25px'>\n";
        while($subject = mysqli_fetch_array($subjects)){
            echo '<tr>';
            echo '<td>', $subject['subjectName'], '</td>';
            echo "</tr>\n";
        }
        echo "</table></td></tr>\n";
    }
}
?>

</table>


<label for="newCourse"> Add new course: </label>
<input type="text" id="newCourse" name="newCourse" />
<input type="submit" name="submit" value="Submit"/>

</form>
