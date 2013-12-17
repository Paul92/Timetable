<?php
/**
 * Constants:
 * SCHEDULE_TABLE - name of the schedule table
 * DEFAULT_START_HOUR - constant for schedule reset
 */
const SCHEDULE_TABLE = 'schedule';
const DEFAULT_START_HOUR = '08:00:00';

/**
 * Get schedule table from database
 *
 * @return mysqli_result $schedule schedule table
 */
function getSchedule(){
    $DB = connect();
    return mysqli_query($DB, "SELECT * FROM ".SCHEDULE_TABLE);
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
function updateSchedule($startH, $dayId){
    $DB = connect();
    $query = "UPDATE ".SCHEDULE_TABLE." SET ";
    $query.= "startHour='" . $startH."', ";
    $query.= "WHERE dayId='".$dayId."';";
    mysqli_query($DB, $query);
}

/**
 * Get slot length
 *
 * @return int slotLength
 */
function getSlotSize(){
    $DB = connect();
    $query = "SELECT * FROM slotSize;";
    $SQL   = mysqli_query($DB, $query);
    $slotSize = mysqli_fetch_array($SQL)['slotLength'];
    return $slotSize;
}

/**
 * Updates slotSize in database
 *
 * @param int $slotSize
 *
 * @return void
 */
function updateSlotSize($slotSize){
    $DB = connect();
    $query = "UPDATE slotSize SET slotLength=".$slotSize.";";
    mysqli_query($DB, $query);
}

