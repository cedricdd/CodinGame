<?php

function GaussianElimination(array $M): array {
    $s = count($M);
    
    for($i = 0; $i < $s; ++$i) {
        
        $posRow = null;
        
        //Find the first row with a 1 in the ith position
        for($j = $i; $j < $s; ++$j) {
            if($M[$j][$i]) {
                $posRow = $j;
                break;
            }
        }
        
        //We need to swap the rows
        if($posRow != $i) [$M[$i], $M[$posRow]] = [$M[$posRow], $M[$i]];
        
        //Each rows below that also has a 1 in the ith position we need to apply XOR with ith row 
        for($j = $i + 1; $j < $s; ++$j) {
            if($M[$j][$i]) {
                for($k = $i; $k <= $s; ++$k) {
                    $M[$j][$k] ^= $M[$i][$k];
                }
            }
        }

    }

    return $M;
}

function solve(array $M): array {
    $solved = [];
    $s = count($M);

    for($i = $s - 1; $i >= 0; --$i) {
        $solved[$i] = $M[$i][$s];

        //We need to update the previous rows
        if($M[$i][$s]) {
            for($j = $i - 1; $j >= 0; --$j) {
                if($M[$j][$i]) $M[$j][$s] ^= 1;
            }
        }
    }

    return $solved;
}

/**
 * @param int $nRows The number of rows in the target pattern.
 * @param int $nCols The number of columns in the target pattern.
 * @param (string)[] $targetPattern The target pattern, row by row from left to right.
 * @return The shortest possible list of pixel coordinates to activate in order to reproduce the target pattern.
 */
function createPattern($h, $w, $targetPattern) {
    // Write your code here
    $start = microtime(1);

    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            
            $index = $y * $w + $x;
            $line = array_fill(0, $w * $h + 1, 0);
            
            if($targetPattern[$y][$x] == "#") $line[$w * $h] = 1;
            
            $line[$index] = 1;
            if($x > 0) $line[$index - 1] = 1;
            if($y > 0) $list[] = $line[$index - $w] = 1;
            if($x < $w - 1) $line[$index + 1] = 1;
            if($y < $h - 1) $line[$index + $w] = 1;
            
            $matrix[$index] = $line;
        }
    }
    
    /*
    error_log(var_export(array_map(function($line) {
        return implode(", ", $line);
    }, $matrix), true));
    */

    $matrix = GaussianElimination($matrix);

    /*
    error_log(var_export(array_map(function($line) {
        return implode(", ", $line);
    }, $matrix), true));
    */

    $solved = solve($matrix);

    $result = [];

    foreach(array_reverse($solved) as $index => $value) {
        if($value) {
            $result[] = [intdiv($index, $w), ($index % $w)];
        }
    }

    error_log(microtime(1) - $start);

    return $result;
}
