<?php

function solve(array $units): string {

    //Until we can no longer reduce
    while(true) {
        krsort($units); //We need them sorted from smallest to biggest

        foreach($units as $i => $v) {
            //We have two adjacent units, merge them
            if(isset($units[$i - 1])) {
                if($units[$i] > 1) --$units[$i];
                else unset($units[$i]);
    
                if($units[$i - 1] > 1) --$units[$i - 1];
                else unset($units[$i - 1]);
    
                $units[$i + 1] = ($units[$i + 1] ?? 0) + 1;

                continue 2;
            } //We only have one unit of each size, we need to use smaller ones to replace one
            if($v > 1) {
                --$units[$i];
                $units[$i - 1] = ($units[$i - 1] ?? 0) + 1;
                $units[$i - 2] = ($units[$i - 2] ?? 0) + 1;

                continue 2;
            }
        }

        break;
    }

    $result = [];

    foreach($units as $i => $v) {
        if($i > 0) $result[] = $i . "L";
        elseif($i == 0) $result[] = "C";
        else $result[] = abs($i) . "R";
    }

    return implode(" ", $result);
}

$start = microtime(1);

fscanf(STDIN, "%d", $n);

echo solve([0 => $n]) . PHP_EOL;

error_log(microtime(1) - $start);
