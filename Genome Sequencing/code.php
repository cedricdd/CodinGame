<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$start = microtime(true);

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s", $sequences[]);
}

error_log(var_export($sequences, true));

//Find all the permutations of the element of a given array
function findPermutation($array, $left) {

    //Nothing left to add, we test this permutation
    if(count($left) == 0) {
        checkPermunation($array);

    } else {
        foreach($left as $key => $sequence) {
            $updatedLeft = $left;
            unset($updatedLeft[$key]);

            findPermutation(array_merge($array, [$sequence]), $updatedLeft);
        }
    }
}

$best = PHP_INT_MAX;

//Calculate the length of this permutation
function checkPermunation($permutation) {
    global $best;

    $string = $permutation[0];
    
    for($i = 1; $i < count($permutation); ++$i) {
        $size = strlen($string);

        //We already have a shortest solution, no need to continue testing this permutation
        if($size >= $best) continue;

        //Find how many characters overlap
        for($j = 0; $j < $size; ++$j) {
            if(strpos($permutation[$i], substr($string, $j, strlen($permutation[$i]))) === 0) break;
        }

        //Add the characters that don't overlap at the end
        $string .= $addition = substr($permutation[$i], $size - $j);;
    }
    
    //We are done with this permutation, check if we found a shortest sequence
    $size = strlen($string);

    if($size < $best) $best = $size;
    
}

findPermutation([], $sequences);

echo $best;
?>
