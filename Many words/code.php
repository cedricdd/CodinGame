<?php

function solve(array $posibilities, array $masks, int $requiredMask, array $maskLeft): int {
    $permutations = [0];

    foreach($posibilities as $i => $possibility) {
        $newPermutations = [];

        $mask = 1;
 

        //Get all the letter that can be used at this position
        while($possibility) {
            if($possibility & 1) {
                foreach($permutations as $permutation) {
                    //We don't want to generate the permutations, we only care of the letters used in the permutation
                    $newPermutation = $permutation | $mask;
    
                    //Check if it's still possible to have all the required letters with the positions we have left
                    if((($newPermutation | $maskLeft[$i]) & $requiredMask) != $requiredMask) continue;
    
                    $newPermutations[] = $newPermutation;
                }
               
            }

            $mask <<= 1;
            $possibility >>= 1;
        }

        $permutations = $newPermutations;
    }

    return count($permutations);
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

$possibilities = array_fill(0, $length, (2 ** $aLen) - 1); //Each positions can use any of the letters from the alphabet

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
            for($i = 0; $i < $length; ++$i) $possibilities[$i] &= ~$masks[$letter]; //This letter can't be anywhere
        }
    } else {
        if($sign == '+') $possibilities[$position - 1] = $masks[$letter]; //That letter is at the position
        else $possibilities[$position - 1] &= ~$masks[$letter]; //That letter can't be at the position
    }
}

$maskLeft = array_fill(0, $length, 0);

for($i = $length - 2; $i >= 0; $i--) {
    $maskLeft[$i] = $possibilities[$i + 1]  | $maskLeft[$i + 1]; //The mask of all the letters that can still be added after position $i
}

echo solve($possibilities, $masks, $requiredMask, $maskLeft) . PHP_EOL;

error_log(microtime(1) - $start);
