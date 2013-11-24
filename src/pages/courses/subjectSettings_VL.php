<?php
    echo "<p>".$data['subjectName']." subject settings</p>\n";
    echo "<p>Available teachers</p>";
    echo '<form method="POST">';
    echo '<table>';
    foreach ($data['teachers'] as $teacher) {
        echo '<tr><td> Teacher ', $teacher['teacherName'];
        echo '<input type="radio" name="teachers[]" value="';
        echo $teacher['teacherId'], '"';
        if (array_search($teacher['teacherId'], $data['taughtBy']) !== FALSE) 
            echo ' checked';
        echo '/>';
        echo '</td></tr>';
    }
    echo '</table>';
    echo '<input type="text" name="hours" value="', $data['hours'], '"/>';
    echo '<input type="hidden" name="subjectId" value="', $data['subjectId'], '"/>';
    echo '<input type="submit" name="submit" value="Submit"/>';
    echo '</form>';
