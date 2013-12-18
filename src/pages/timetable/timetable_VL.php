<?php
if (isset($errors)) {
    foreach ($errors as $error) {
        echo $error, '</br>';
    }
}

$timetable = $data['timetable'];
$dayNames  = $data['dayNames'];

$ok = true;
$i = 0;

echo "<table border='1'>\n";
echo "<tr>";
foreach($timetable as $dayId => $course){
    echo "<td> $dayNames[$dayId] </td>";
}
echo "</tr>";

while($ok){
    $ok = false;
    echo "<tr>\n";
    foreach($timetable as $day){
        if(isset($day[$i])){
            $ok = true;
            $course = $day[$i];
            echo '<td>', $course['subject'];
            echo '<br>', $course['startHour'];
            echo '<br>', $course['teacher'], "</td>\n";
        }
    }
    $i++;
    echo "</tr>\n";
}
echo "</table>";





