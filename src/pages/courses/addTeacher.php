<?php
/**
 * Submodule for addition teachers to a course. It handles addition form and database
 * update
 */

if (!file_exists(DATABASE_MODULE) || !is_readable(DATABASE_MODULE)) {
    exit(DATABASE_MODULE_NOT_FOUND);
}
require_once(DATABASE_MODULE);

$DB = connect();

if (isset($_POST['submit']) && isset($_POST['teachers']) && isset($_POST['subjectId'])) {
    foreach($_POST['teachers'] as $teacher){
        $query = 'INSERT INTO teachersToSubject (subjectId, teacherId) VALUES (';
        $query.= $_POST['subjectId'].', '.$teacher.');';
    }
    mysqli_query($DB, $query);
    header('Location: ?show=courses');
}


if (isset($_GET['subjectName'])) {
    echo "<p>Add a teacher to ".$_GET['subjectName']." subject</p>\n";
    echo "<p>Available teachers</p>";
    echo '<form method="POST">';
    echo '<table>';
    $teachers = mysqli_query($DB, "SELECT * FROM teachers");
    while ($teacher = mysqli_fetch_array($teachers)) {
        echo '<tr><td> Teacher ', $teacher['teacherName'];
        echo '<input type="checkbox" name="teachers[]" value="', $teacher['teacherId'], '"/>';
        echo '</td></tr>';
    }
    echo '</table>';
    echo '<input type="hidden" name="subjectId" value="', $_GET['subjectId'], '"/>';
    echo '<input type="submit" name="submit" value="Submit"/>';
    echo '</form>';
} else {
    echo "ERROR: CourseName not set\n";
}
