<?php
$DB = mysqli_connect('localhost' ,'mysql' ,'123456' ,'timetable');

if(!$DB){
    exit('Connect error '.mysqli_connect_errno());
}

$schedule = mysqli_query($DB, "SELECT * FROM schedule");

if(isset($_POST['submit'])){
    while($day = mysqli_fetch_array($schedule)){
        $startH = $day['dayName']."_startHour";
        $endH   = $day['dayName']."_endHour";

        $query = "UPDATE schedule SET ";
        $query.= "startHour='" . $_POST[$startH]."', ";
        $query.= "endHour='".$_POST[$endH]."' ";
        $query.= "WHERE dayId='".$day['dayId']."'";

        $out = mysqli_query($DB, $query);
    }
    $schedule = mysqli_query($DB, "SELECT * FROM schedule");
}


?>




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

