<?php

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
