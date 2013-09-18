<?php

const TABLE_NAME schedule

function getSchedule(){
    return mysqli_query($DB, "SELECT * FROM TABLE_NAME");
}

function updateSchedule($startH, $endH, $dayId){
    $query = "UPDATE TABLE_NAME SET ";
    $query.= "startHour='" . $_POST[$startH]."', ";
    $query.= "endHour='".$_POST[$endH]."' ";
    $query.= "WHERE dayId='".$day['dayId']."'";
}

$schedule = getSchedule();

if(isset($_POST['submit'])){
    while($day = mysqli_fetch_array($schedule)){
        $startH = $_POST[$day['dayName']."_startHour"];
        $endH   = $_POST[$day['dayName']."_endHour"];
        updateSchedule($startH, $endH, $dayId);
        $out = mysqli_query($DB, $query);
    }
    $schedule = getSchedule();
}

?>
