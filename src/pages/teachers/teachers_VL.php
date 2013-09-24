<?php include 'teachers_BL.php'; ?>

<form method="POST">

<table>

<?php
while($teacher = mysqli_fetch_array($teachers)){
    echo "<tr>\n";
    echo '<td> Teacher ', $teacher['teacherId'], ': <a href="?show=subjectsTaught&amp;teacherName=', $teacher['teacherName'];
    echo '&amp;teacherId=', $teacher['teacherId'], '">', $teacher['teacherName'], '</a></td></tr>';
}
?>

</table>

<label for="newTeacher"> Add new teacher: </label>
<input type="text" id="newTeacher" name="newTeacher"/>
<input type="submit" name="submit" value="Submit"/>
</form>
