<?php
$DB = mysqli_connect('localhost' ,'mysql' ,'123456' ,'timetable');

if(!$DB){
    exit('Connect error '.mysqli_connect_errno());
}

$schedule = mysqli_query($DB, "SELECT * FROM schedule");

echo '<form method="POST">';

echo '<table>';
echo '<tr><td>Day name</td><td>Start hour</td><td>End hour</td>';
while($day = mysqli_fetch_array($schedule)){
    echo '<tr>';
    echo '<td><b>'.$day['dayName'].'</b></td>';
    echo '<td>';
    echo '<input type="text" name="'.$day['dayName'].'_startHour" value="'.$day['startHour'].'"/>';
    echo '</td><td>';
    echo '<input type="text" name="'.$day['dayName'].'_endHour" value="'.$day['endHour'].'"/>';
    echo '</td></tr>';

}
echo '</table>';

