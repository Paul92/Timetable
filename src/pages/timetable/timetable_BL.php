<?php
/**
 * Timetable generator module
 * This submodule deals with database fetching, data checking and calls 
 * genenerateTimetable function
 */

require_once(DATABASE_MODULE);
$DB = connect();

require_once('pages/timetable/functions.php');
require_once('pages/schedule/functions.php');

const GENERATION_SIZE = 10;

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


$timetable = parse($DB, $generation[0]['individual']);

$dayNames = array();
foreach($timetable as $dayId => $value)
    $dayNames[$dayId] = getDayName($DB, $dayId+1);

//Pass data to VL
if (isset($errors) && !empty($errors)) {
    return $errors;
} else {
    return array('timetable' => $timetable,
                 'dayNames'  => $dayNames);
}

