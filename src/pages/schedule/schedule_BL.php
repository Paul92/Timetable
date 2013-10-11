<?php
/**
 * Schedule module. It handles schedule viewing and changing
 */

require_once(DATABASE_MODULE);

/**
 * Constants:
 * TABLE_NAME - name of the schedule table
 * DEFAULT_START_HOUR - constant for schedule reset
 * DEFAULT_END_HOUR   - constant for schedule reset
 */
const TABLE_NAME = 'schedule';
const DEFAULT_START_HOUR = '08:00:00';
const DEFAULT_END_HOUR   = '16:00:00';

/**
 * Get schedule table from database
 *
 * @return mysqli_result $schedule schedule table
 */
function getSchedule(){
    $DB = connect();
    return mysqli_query($DB, "SELECT * FROM ".TABLE_NAME);
}

/**
 * Update schedule table from database
 *
 * @param str $startH start hour
 * @param str $endH   end hour
 * @param str $dayId  id of day to update
 *
 * @return bool $ok true if query succeeded
 */
function updateSchedule($startH, $endH, $dayId){
    $DB = connect();
    $query = "UPDATE ".TABLE_NAME." SET ";
    $query.= "startHour='" . $startH."', ";
    $query.= "endHour='".$endH."' ";
    $query.= "WHERE dayId='".$dayId."';";
    mysqli_query($DB, $query);
}

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
        $endH   = $_POST[$day['dayName']."_endHour"];

        sscanf($startH, "%d:%d:%d", $sH, $sM, $sS);
        sscanf($endH, "%d:%d:%d", $eH, $eM, $eS);

        if ($sM != $eM || $sS != $eS) {
            $errors[] = 'Start/stop minutes and/or seconds are not equal on ' . $day['dayName'];
            break;
        }
        if ($sH >= $eH){
            $errors[] = 'Start hour is later or equal with end hour on ' . $day['dayName'];
            break;
        }

        $dayId  = $day['dayId'];
        updateSchedule($startH, $endH, $dayId);
    }
}

if (isset($_POST['reset'])) {
    $schedule = getSchedule();
    while ($day = mysqli_fetch_array($schedule)) {
        $dayId = $day['dayId'];
        updateSchedule(DEFAULT_START_HOUR, DEFAULT_END_HOUR, $dayId);
    }
}

$data['schedule'] = getSchedule();
$data['errors'] = $errors;
return $data;

