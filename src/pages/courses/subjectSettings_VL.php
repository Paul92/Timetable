<?php
    echo "<p>".$data['subjectName']." subject settings</p>\n";
    echo "<p>Available teachers</p>";
    echo '<form method="POST">';
    echo '<table>';
    while ($teacher = mysqli_fetch_array($data['teachers'])) {
        echo '<tr><td> Teacher ', $teacher['teacherName'];
        echo '<input type="checkbox" name="teachers[]" value="';
        echo $teacher['teacherId'], '"/>';
        echo '</td></tr>';
    }
    echo '</table>';
    echo '<input type="text" name="hours" value="', $data['hours'], '"/>';
    echo '<input type="hidden" name="subjectId" value="', $data['subjectId'], '"/>';
    echo '<input type="submit" name="submit" value="Submit"/>';
    echo '</form>';
