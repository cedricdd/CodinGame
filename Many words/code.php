<?php

function solve(array $posibilities, int $requiredMask): int {
    global $masks;

    $permutations = [0];

    foreach($posibilities as $i => $list) {
        $newPermutations = [];

        foreach($permutations as $permutation) {
            foreach($list as $letter => $filler) {
                //We don't want to generate the permutations, we only care of the letters used in the permutation
                $newPermutations[] = $permutation | $masks[$letter];
            }
        }

        $permutations = $newPermutations;
    }

    $total = 0;

    foreach($permutations as $permutation) {
        //Check if all the requiered letter are present
        if(($permutation & $requiredMask) == $requiredMask) $total++;
    }

    return $total;
}

function factorial(int $number): int { 
    $factorial = 1; 

    for ($i = 1; $i <= $number; $i++){ 
        $factorial *= $i; 
    }

    return $factorial; 
} 

$start = microtime(1);

fscanf(STDIN, "%d", $aLen);

$alphabet = preg_split('//u', trim(fgets(STDIN)), -1, PREG_SPLIT_NO_EMPTY);

foreach($alphabet as $i => $letter) $masks[$letter] = 2 ** $i; //We set a mask for each letter

fscanf(STDIN, "%d", $length);

$output = array_fill(0, $length, array_flip($alphabet)); //Each positions can use any of the letters from the alphabet

fscanf(STDIN, "%d", $ruleN);

//Every possibility is ok
if($ruleN == 0) {
    $count = $aLen ** $length;
    exit("$count");
}

$requiredMask = 0;

for ($i = 0; $i < $ruleN; $i++) {
    preg_match("/^([+-])(.*)([0-9]+)$/", trim(fgets(STDIN)), $matches);

    [, $sign, $letter, $position] = $matches;

    if($position == 0) {
        if($sign == '+') $requiredMask |= $masks[$letter]; //We need this letter at least once
        else {
            for($i = 0; $i < $length; ++$i) unset($output[$i][$letter]); //This letter can't be anywhere
        }
    } else {
        if($sign == '+') $output[$position - 1] = [$letter]; //That letter is at the position
        else unset($output[$position - 1][$letter]); //That letter can't be at the position
    }
}

echo solve($output, $requiredMask) . PHP_EOL;

error_log(microtime(1) - $start);
