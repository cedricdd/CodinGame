<?php

function getMax(array $digits): string {
    $result = "";

    for($i = 9; $i >= 0; --$i) $result .= str_repeat($i, $digits[$i]);

    return $result;
}

function getMin(array $digits): string {
    $result = "";

    for($i = 0; $i <= 9; ++$i) $result .= str_repeat($i, $digits[$i]);

    return $result;  
}

function solve(string $n, array $digits): string {

    $s1 = strlen($n);
    $s2 = array_sum($digits);
    
    if($s1 > $s2) return getMax($digits);
    
    if($s1 < $s2) {
        //Try to remove some '0'
        if($digits[0]) {
            $count = min($digits[0], $s2 - $s1);
            $digits[0] -= $count;
            $s2 -= $count;
        }
    }
    
    if($s1 < $s2) return getMin($digits);
    
    for($i = 0; $i < $s1; ++$i) {
        if($digits[$n[$i]]) {
            $digits[$n[$i]]--;
    
            //We can completly recreate the first integer with the digits of the second integer
            if($i == $s1 - 1) return $n;
             //We have more common digits
            elseif($digits[$n[$i + 1]]) continue;
            //We are done with the sequence of common prefix we are using for sure
            else $digits[$n[$i]]++;
        }
    
        $value = substr($n, $i);
    
        error_log("working on $value -- " . substr($n, 0, $i));
        error_log(var_export($digits, true));
    
        $closest = "";
        $closestDistance = null;
    
        for($j = 0; $j <= 9; ++$j) {
            if($digits[$j]) {
                $digits[$j]--;
    
                if($j > $n[$i]) {
                    $value2 = $j . getMin($digits);
    
                    error_log("we are using $j -- $value2");
                } elseif($j < $n[$i]) {
                    $value2 = $j . getMax($digits);
    
                    error_log("we are using $j -- $value2");
                } elseif($j == $n[$i]) {
                    $value2 = $j . solve(substr($value, 1), $digits);

                    error_log("we are using $j -- $value2");
                }

                if(bccomp($value, $value2) == 1) $distance = bcsub($value, $value2);
                else $distance = bcsub($value2, $value);
    
                if($closestDistance === null || bccomp($distance, $closestDistance) == -1) {
                    $closestDistance = $distance;
                    $closest = $value2;
                }
    
                $digits[$j]++;
            }
        }
    
        return substr($n, 0, $i) . $closest;
    }
}

fscanf(STDIN, "%s %s", $n, $M);

$digits = array_fill(0, 10, 0);

foreach(str_split($M) as $d) $digits[$d]++;

echo solve($n, $digits) . PHP_EOL;
