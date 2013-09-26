<?php
/**
 * Submodule for course addition. It handles addition form and database
 * update
 */

if (!file_exists(DATABASE_MODULE) || !is_readable(DATABASE_MODULE)) {
    exit(DATABASE_MODULE_NOT_FOUND);
}
require_once(DATABASE_MODULE);

$DB = connect();

$teachers = mysqli_query($DB, "SELECT * FROM teachers");
if (isset($_POST['subjectName']) && isset($_POST['teachers'])) {
    $query = 'INSERT INTO subjects (subjectName, courseId) VALUES ("';
    $query.= $_POST['subjectName'].'", '.$_POST['courseId'].');';
    $DB = connect();
    mysqli_query($DB, $query);
    $subjectId = mysqli_insert_id($DB);
    foreach ($_POST['teachers'] as $teacherId) {
        $query = 'INSERT INTO teachersToSubject (subjectId, teacherId) VALUES (';
        $query.= $subjectId.', '.$teacherId.');';
        mysqli_query($DB, $query);
    }
    header('Location: ?show=courses');
}


if (isset($_GET['courseName'])) {
    echo "<p>Add a subject to ".$_GET['courseName']." course</p>\n";
    echo "<form method='POST'>\n";
    echo "<label for='subjectName'>Subject Name: </label>\n";
    echo "<input type='hidden' name='courseId' value='".$_GET['courseId']."'/>\n";
    echo "<input type='text' id='subjectName' name='subjectName' />\n";
    echo "<br>";
    while ($teacher = mysqli_fetch_array($teachers)) {
        echo "Teacher ", $teacher['teacherName'];
        echo "<input type='checkbox' name='teachers[]' value='", $teacher['teacherId'], "'/>";
        echo "<br>";
    }
    echo "<input type='submit' name='submit' value='Submit' />\n";
    echo "</form>";
} else {
    echo "ERROR: CourseName not set\n";
}
