<?php
//TODO: check for $_GET['courseId']
echo "<p>Add a subject to ".$data['courseName']." course</p>\n";
echo "<form method='POST'>\n";
echo "<label for='subjectName'>Subject Name: </label>\n";
echo "<input type='hidden' name='courseId' value='".$_GET['courseId']."'/>\n";
echo "<input type='text' id='subjectName' name='subjectName' />\n";
echo "<br>";
while ($teacher = mysqli_fetch_array($data['teachers'])) {
    echo "Teacher ", $teacher['teacherName'];
    echo "<input type='radio' name='teachers[]' value='", $teacher['teacherId'], "'/>";
    echo "<br>";
}
echo "<input type='submit' name='submit' value='Submit' />\n";
echo "</form>";
