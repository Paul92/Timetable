<?php
if (isset($errors)) {
    foreach ($errors as $error) {
        echo $error, '</br>';
    }
}

$timetable = $data;

echo "<table>\n";
foreach($timetable as $day){
    echo "<tr>\n";
    foreach($day as $course){
        echo '<td>', $course['startHour'], "</td>\n";
        echo '<td>', $course['endHour'], "</td>\n";
        echo '<td>', $course['subject'], "</td>\n";
        echo '<td>', $course['teacher'], "</td>\n";
    }
    echo "</tr>\n";
}


