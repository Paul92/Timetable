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

//end of testing function

$generation = array();
for($i = 0; $i < GENERATION_SIZE; $i++){
    $individual = generate($DB);
    $individualFitness = fitness($DB, $individual);
    $element    = array(
        'individual' => $individual, 
        'fitness'    => $individualFitness
    );
    $generation[] = $element;
}

usort($generation, "comp");

while(!accepted($generation[0]['fitness'])){
    //random crossover
    $a = rand(0, GENERATION_SIZE-1);
    $b = rand(0, GENERATION_SIZE-1);
    if($a != $b){
        $newIndividual = crossover($generation[$a]['individual'],
                                   $generation[$b]['individual']);
        $newIndividualFitness = fitness($DB, $newIndividual);
        $aFitness = $generation[$a]['fitness'];
        $bFitness = $generation[$b]['fitness'];
        if(!fitness_compare($aFitness, $bFitness)){
            if(!fitness_compare($aFitness, $newIndividualFitness)){
                $generation[$a]['individual'] = $newIndividual;
                $generation[$a]['fitness']    = $newIndividualFitness;
            }else{
                $generation[$b]['individual'] = $newIndividual;
                $generation[$b]['fitness']    = $newIndividualFitness;
            }
        }else{
            if(!fitness_compare($bFitness, $newIndividualFitness)){
                $generation[$b]['individual'] = $newIndividual;
                $generation[$b]['fitness']    = $newIndividualFitness;
            }else{
                $generation[$a]['individual'] = $newIndividual;
                $generation[$a]['fitness']    = $newIndividualFitness;
            }
        }
    }

    //mutation
    $a = rand(0, GENERATION_SIZE-1);
    $newIndividual = mutate($generation[$a]['individual']);
    $newIndividualFitness = fitness($DB, $newIndividual);
    if(fitness_compare($newIndividualFitness, $generation[$a]['fitness'])){
        $generation[$a]['individual'] = $newIndividual;
        $generation[$a]['fitness']    = $newIndividualFitness;
    }

    usort($generation, "comp");
}


$ret = parse($DB, $generation[0]['individual']);
//Pass data to VL
if (isset($errors) && !empty($errors)) {
    return $errors;
} else {
    return $ret;
}

