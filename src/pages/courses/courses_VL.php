<?php include 'courses_BL.php'; ?>

<form method="POST">

<table>

<?php
while($course = mysqli_fetch_array($courses)){
    echo "<tr>\n";
    echo '<td> Course ', $course['courseId'], ': <a href="?show=addSubject&amp;courseName=', $course['courseName'];
    echo '&amp;courseId=', $course['courseId'], '">', $course['courseName'], "</a></td>\n";
    echo '<td> <button type="submit" name="deleteCourse[]" value="', $course['courseId'], '">Delete</button></td>';
    echo '</tr>';
    $subjects = mysqli_query($DB, "SELECT * FROM subjects WHERE courseId='".$course['courseId']."'");
    if($subjects){
        echo "<tr><td><table border='1' style='margin-left: 25px'>\n";
        while($subject = mysqli_fetch_array($subjects)){
            echo '<tr>';
            echo '<td style="width:300px"><a href="?show=addTeacher&amp;subjectName=', $subject['subjectName'];
            echo '&amp;subjectId=', $subject['subjectId'], '">';
            echo $subject['subjectName'], '</a></td>';
            echo '<td> <button type="submit" name="delete[]" value="', $subject['subjectId'], '">Delete</button></td>';
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
