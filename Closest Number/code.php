<?php

//Get the max number we can generate with the given digits
function getMax(array $digits): string {
    $result = "";

    for($i = 9; $i >= 0; --$i) $result .= str_repeat($i, $digits[$i]);

    return $result;
}

//Get the min number we can generate with the given digits
function getMin(array $digits): string {
    $result = "";

    for($i = 0; $i <= 9; ++$i) $result .= str_repeat($i, $digits[$i]);

    return $result;  
}

function solve(string $n, array $digits): string {

    $s1 = strlen($n);
    $s2 = array_sum($digits);
    
    //N has more digits and no leading 0, the result is the biggest possible integer with the digits of M
    if($s1 > $s2) return getMax($digits);
    
    //N has less digits than M
    if($s1 < $s2) {
        //Try to remove some '0' from M, we would just use them as 'leading zero'
        if($digits[0]) {
            $count = min($digits[0], $s2 - $s1);
            $digits[0] -= $count;
            $s2 -= $count;
        }
    }
    
    //N still has less digits than M, the result is the lowest possible integer with the digits of M
    if($s1 < $s2) return getMin($digits);
    
    //Find the position where we need to start working
    for($i = 0; $i < $s1; ++$i) {
        //We can match that digit
        if($digits[$n[$i]]) {
            $digits[$n[$i]]--;
    
            //We can completly recreate the first integer with the digits of the second integer
            if($i == $s1 - 1) return $n;
            //We can use more common digits for sure
            elseif($n[$i + 1] != 0 && $digits[$n[$i + 1]]) continue;
            //We are done with the sequence of common prefix we are using for sure
            else $digits[$n[$i]]++;
        }
    
        //At this point we have the common prefix we will be using, $value is what's left
        $value = substr($n, $i);
    
        /**
         * We need to check 3 digits at most, the exact digit if possible + the closest digits above & below the exact digit
         */

        $digit = $n[$i];

        //The exact digit
        if($digits[$digit]) {
            $digits[$digit]--;
            $values[] = $digit . solve(substr($value, 1), $digits);
            $digits[$digit]++;
        }

        //The closest digit above
        for($j = $digit + 1; $j <= 9; ++$j) {
            if($digits[$j]) {
                $digits[$j]--;
                $values[] = $j . getMin($digits);
                $digits[$j]++;

                break;
            }
        }

        //The closest digit below
        for($j = $digit - 1; $j >= 0; --$j) {
            if($digits[$j]) {
                $digits[$j]--;
                $values[] = $j . getMax($digits);
                $digits[$j]++;

                break;
            }
        }

        $closest = "";
        $closestDistance = null;
        sort($values, SORT_STRING); //If two values have the same distance we want the lowest numerical

        //Get the closest from N
        foreach($values as $value2) {
            if(bccomp($value, $value2) == 1) $distance = bcsub($value, $value2);
            else $distance = bcsub($value2, $value);

            if($closestDistance === null || bccomp($distance, $closestDistance) == -1) {
                $closestDistance = $distance;
                $closest = $value2;
            }
        }
    
        return substr($n, 0, $i) . $closest;
    }
}

$start = microtime(1);

fscanf(STDIN, "%s %s", $n, $M);

$digits = array_fill(0, 10, 0);

foreach(str_split($M) as $d) $digits[$d]++;

echo solve($n, $digits) . PHP_EOL;

error_log(microtime(1) - $start);
