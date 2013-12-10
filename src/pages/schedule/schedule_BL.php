<?php
/**
 * Schedule module. It handles schedule viewing and changing
 */
require_once(DATABASE_MODULE);
require_once('pages/schedule/functions.php');

/**
 * $data - variabile to pass data to VL
 * $error - variable to pass errors
 */
$data = array();
$errors = array();

if (isset($_POST['submit'])) {
    $schedule = getSchedule();
    while ($day = mysqli_fetch_array($schedule)) {
        $startH = $_POST[$day['dayName']."_startHour"];

        sscanf($startH, "%d:%d:%d", $sH, $sM, $sS);

        $dayId  = $day['dayId'];
        updateSchedule($startH, $dayId);
    }
    updateSlotSize($_POST['slotSize']);
}

if (isset($_POST['reset'])) {
    $schedule = getSchedule();
    while ($day = mysqli_fetch_array($schedule)) {
        $dayId = $day['dayId'];
        updateSchedule(DEFAULT_START_HOUR, $dayId);
    }
}

$data['schedule'] = getSchedule();
$data['slotSize'] = getSlotSize();

$data['errors'] = $errors;
return $data;

