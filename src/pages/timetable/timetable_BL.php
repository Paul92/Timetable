<?php
/**
 * Timetable generator module
 * This submodule deals with database fetching, data checking and calls 
 * genenerateTimetable function
 */

require_once(DATABASE_MODULE);
$DB = connect();

require_once('pages/timetable/functions.php');

const GENERATION_SIZE = 10;

//checks

$noOfSlots = countScheduleSlots($DB);
if($noOfSlots != countSubjectSlots($DB))
    $errors[] = "Too many/less time slots";

//testing function

function print_arr($arr){
    foreach($arr as $element)
        echo $element, ' ';
    echo "\n";
}

$population = generate_generation($DB, GENERATION_SIZE);
$generationFitness = array();
foreach($population as $generation){
    $generationFitness[] = fitness($DB, $generation);
}

$ret = $generationFitness;
$ret = parse($DB, $population[0]);

//Pass data to VL
if (isset($errors) && !empty($errors)) {
    return $errors;
} else {
    return $ret;
}

