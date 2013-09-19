<?php include 'schedule_BL.php'; ?>

<form method="POST">

<table>
<tr><td>Day name</td><td>Start hour</td><td>End hour</td>

<?php
while($day = mysqli_fetch_array($schedule)){
    echo '<tr>';
    echo '<td><b>'.$day['dayName'].'</b></td>';
    echo '<td><input type="text" name="'.$day['dayName'].'_startHour" value="'.$day['startHour'].'"/></td>';
    echo '<td><input type="text" name="'.$day['dayName'].'_endHour" value="'.$day['endHour'].'"/></td>';
    echo '</tr>';
}
?>

</table>
<input type="submit" name="submit" value="Submit"/>
</form>
