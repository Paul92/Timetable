<?php
/**
 * Schedule module. It handles schedule viewing and changing
 */

require_once(DATABASE_MODULE);

/**
 * Constants:
 * TABLE_NAME - name of the schedule table
 */
const TABLE_NAME = 'schedule';

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
    $query = "UPDATE TABLE_NAME SET ";
    $query.= "startHour='" . $_POST[$startH]."', ";
    $query.= "endHour='".$_POST[$endH]."' ";
    $query.= "WHERE dayId='".$day['dayId']."'";
    mysqli_query($DB, $query);
}

/**
 * Variabile to hold schedule table
 */
$schedule = getSchedule();

if (isset($_POST['submit'])) {
    while ($day = mysqli_fetch_array($schedule)) {
        $startH = $_POST[$day['dayName']."_startHour"];
        $endH   = $_POST[$day['dayName']."_endHour"];
        updateSchedule($startH, $endH, $dayId);
    }
    $schedule = getSchedule();
}

