<form method="POST">

<table>

<?php
foreach($data['courses'] as $course){
    echo "<tr>\n";
    echo '<td> Course ', $course['courseId'], ':';
    echo '<a href="?show=addSubject&amp;courseName=', $course['courseName'];
    echo '&amp;courseId=', $course['courseId'], '">', $course['courseName'];
    echo "</a></td>\n";

    echo '<td> <button type="submit" name="deleteCourse[]"';
    echo 'value="', $course['courseId'], '">Delete</button></td>', "\n";
    echo "</tr>\n";

    foreach($data[$course['courseId']] as $subject){
        echo "<tr><td><table border='1' style='margin-left: 25px'>\n";
        echo "<tr>\n";
        echo '<td style="width:300px">';
        echo '<a href="?show=addTeacher&amp;subjectName=';
        echo $subject['subjectName'];
        echo '&amp;subjectId=', $subject['subjectId'], '">';
        echo $subject['subjectName'], '</a></td>', "\n";
        echo '<td> <button type="submit" name="delete[]" value="';
        echo $subject['subjectId'], '">Delete</button></td>', "\n";
        echo "</tr>\n";
        echo "</table></td></tr>\n";
    }
}
?>

</table>


<label for="newCourse"> Add new course: </label>
<input type="text" id="newCourse" name="newCourse" />
<input type="submit" name="submit" value="Submit"/>

</form>
