<?php

if(!file_exists('database.php') || !is_readable('database.php')){
    exit(DATABASE_MODULE_NOT_FOUND);
}

require_once('database.php');

$DB = connect();

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
