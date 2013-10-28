<?php
/**
 * This module helper contains functions needed for timetable generation. 
 * The algorithm used is a genetic algoritm. There are few steps required:
 *
 * 1. First generation
 * - it is a random generation of a timetable
 * - in order to accomplish this, $data[$subjects] array should be iterated,
 * find a empty slot (random) and put the subject in that slot
 * - if the random slot is not empty, it should search for the NEAREST empty
 * slot (a linear search will do).
 *
 * 2. After first generation, the evolving process should start. This is 
 *    accomplished by 3 genetic operations:
 *    - reproduction
 *    - crossover
 *    - mutation
 *
 * 2.1. Reproduction
 *    - is just a copy of an individual
 *
 * 2.2. Crossover
 *    - take 2 individuals that are going to reproduce
 *    - select a random crossover point, spliting individuals A and B into 4
 *      parts: A1, A2, B1, B2
 *    - crossover them
 *    - the 2 new individuals will look like this: A1B2, B1A2
 *
 * 2.3. Mutation
 *    - randomly change an individual's attribute
 *
 * 3. Fitness
 *    - every time an individual is created, it's fitness should be evaluated
 *    - fitness is a mark given to a certain individual that represents how
 *    good is it, i.e. how many constraints it satisfies
 *    - there are 2 types of constraints: hard ones and soft ones. Hard ones
 *    MUST be satisfied. Soft ones (like teacher preferences) should be 
 *    satisfied, if possible
 *    - depending on how many constraints an individual satisfies, a mark is
 *    given to it.
 *    - "mark" is a compound structure (a, b). a represents number of hard 
 *    constraints that are NOT satisfied, and b represents number of soft
 *    constraints that are NOT satisfied.
 *    - an ideal individual has mark (0, 0), but this may ethier be not fesable
 *    or would require too much resources to compute
 *    - an acceptable individual has mark (0, x), where x should be as small as 
 *    possible. 
 *
 * NOTES:
 *    - after an evolution step (2.2, 2.3), the new individual should not be 
 *    added to individual's list if it has a smaller mark
 *
 * The evolving process should stop when an acceptable individual is found.
 *
 * The timetable data structure:
 *
 * $timetable = array(slot1, slot2, ..., slotn);
 *  , where slot1, ..., slotn represents the subject ID taken in that slot.
 *  the first k slots represents monday slots, where k is the number of slots
 *  from monday. Simillar for other days. The size of $timetable MUST be equal
 *  with the number of slots in a week.
 *
 * A generation is a array of timetables, each one being an individual.
 * $generation = array($individual1, ..., $individualn),
 * where $individualk is a timetable
 */



/**
 * mixed generate_individual(mixed $data)
 *
 * @param mixed $data - data used for timetable generation, as described in
 *                      timetable_BL.php
 *
 * @return mixed timetable - returns a randomly generated timetable, as 
 *                           documented at the beginning of this file
 */
function generate($data) {

    $timetable = array();
    foreach ($data['noOfSlots'] as $key => $subjectSlots) {
        while ($subjectSlots) {
            $timetable[] = $data['subjects'][$key];
            $subjectSlots--;
        }
    }

    shuffle($timetable);

    return $timetable;
}


/**
 * mixed generate_generation(mixed $data, int $generationSize)
 *
 * @param mixed $data - data used for timetable generation, as described in
 *                      timetable_BL.php
 * @param int $generationSize - generation size
 *
 * @return mixed generation - returns a randomly generated generation, with
 *                            generationSize individuals, as documented at
 *                            the beginning of this file
 */
function generate_generation($data, $generationSize) {

    $generation = array();
    for ($i = 0; $i < $generationSize; $i++) {
        $generation[] = generate($data);
    }

    return $generation;

}
