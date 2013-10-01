<form method="POST">

<table>

<?php
foreach($data['teachers'] as $teacher){
    echo "<tr>\n";
    echo '<td> Teacher ', $teacher['teacherId'], ':';
    echo $teacher['teacherName'], '</td>';
    echo '<td><button type="submit" name="deleteTeacher[]" ';
    echo 'value=', $teacher['teacherId'], '>Delete</button></td>';
    echo '</tr>';
    foreach($data[$teacher['teacherId']] as $subjectsTaught){
        echo "<tr><td><table border='1' style='margin-left: 25px'>\n";
        while($subject = mysqli_fetch_array($subjectsTaught)){
            echo '<tr>';
            echo '<td style="width:300px">', $subject['subjectName'], '</td>';
            echo '<td><button type="submit" name="removeSubject[]" ';
            echo ' value="', $subject['subjectId'], '">Remove</button></td>';
            echo '</tr>';
        }
        echo "</table>";
    }
}

?>

</table>

<label for="newTeacher"> Add new teacher: </label>
<input type="text" id="newTeacher" name="newTeacher"/>
<input type="submit" name="submit" value="Submit"/>
</form>
