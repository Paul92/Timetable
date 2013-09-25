<?php include 'teachers_BL.php'; ?>

<form method="POST">

<table>

<?php
while($teacher = mysqli_fetch_array($teachers)){
    echo "<tr>\n";
    echo '<td> Teacher ', $teacher['teacherId'], ':';
    echo $teacher['teacherName'], '</td>';
    echo '<td><button type="submit" name="deleteTeacher[]" value=', $teacher['teacherId'], '>Delete</button></td>';
    echo '</tr>';
    $subjectsTaughtId = mysqli_query($DB, "SELECT subjectId FROM teachersToSubject WHERE teacherId=".$teacher['teacherId'].";");
    if($subjectsTaughtId){
        echo "<tr><td><table border='1' style='margin-left: 25px'>\n";
        while($subjectTaughtId = mysqli_fetch_array($subjectsTaughtId)){
            $subjects = mysqli_query($DB, "SELECT * FROM subjects WHERE subjectId=".$subjectTaughtId['subjectId'].";");
            while($subject = mysqli_fetch_array($subjects)){
                echo '<tr>';
                echo '<td style="width:300px">', $subject['subjectName'], '</td>';
                echo '<td><button type="submit" name="removeSubject[]" value="', $subject['subjectId'], '">Remove</button></td>';
                echo '</tr>';
            }
        }
        echo '</table>';
    }

        
}
?>

</table>

<label for="newTeacher"> Add new teacher: </label>
<input type="text" id="newTeacher" name="newTeacher"/>
<input type="submit" name="submit" value="Submit"/>
</form>
