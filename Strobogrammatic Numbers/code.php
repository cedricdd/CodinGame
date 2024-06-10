<?php

//Check if a single number is a Strobogrammatic Number
function isStrobogrammiticNumber(string $number): int {
    if(strrev($number) == strtr($number, "01689", "01986")) return 1;
    else return 0;
}

//Get how many Strobogrammatic Numbers of a given size exist
function getCountTotal(int $size, bool $leadingZeroAllowed = false): int {
    if($size <= 0) return 1;

    $count = (($size & 1) == 0) ? 1 : 3;

    for($i = ($size >> 1); $i > 0; --$i) {
        if($i == 1 && $leadingZeroAllowed == false) $count *= 4; //We don't want '0' as first digit
        else $count *= 5;
    }

    return $count;
}

//Get how many Strobogrammatic Numbers of a given size exist up to a given max
function getCountUpTo(int $position, string $set, string $max): int {
    $count = 0;

    $size = strlen($max) - ($position * 2); //How many positions are still 'open'

    if($size <= 0) return intval($set) <= intval($max) ? 1 : 0; //We filled up all the positions

    $full = getCountTotal($size - 2, true); 

    foreach([[0, 0], [1, 1], [6, 9], [8, 8], [9, 6]] as $index => [$start, $end]) {
        if($index == 0 && $position == 0) continue; //We don't want to '0' as first digit
        if($size == 1 && $start != $end)  continue; //We only have 1 position not set

        if($start < $max[$position]) $count += $full; //All these numbers will be below the max
        //We are using the same digit as in the max number, need to call recursive to find how many are below the max
        elseif($start == $max[$position]) {
            $set[$position] = $start;
            $set[($position + 1) * -1] = $end;

            return $count + getCountUpTo($position + 1, $set, $max);
        }
        else break; //All these numbers will be above the max
    }

    return $count;
}

$start = microtime(1);

$low = stream_get_line(STDIN, 4096 + 1, "\n");
$sLow = strlen($low);
$high = stream_get_line(STDIN, 4096 + 1, "\n");
$sHigh = strlen($high);

//We are only working on a single number
if($low == $high) {
    echo isStrobogrammiticNumber(strval($low)) . PHP_EOL;
    exit();
}

$total = 0; 

//Add everything where we count all the numbers of size $size
for($size = $sLow; $size < $sHigh; ++$size) {
    $check = getCountTotal($size);

    $total += $check;
}

//Remove all the number of the same size as min but lower than min
$total -= getCountUpTo(0, str_repeat('0', $sLow), $low);
//Add all the number of the same size as max but lower than max
$total += getCountUpTo(0, str_repeat('0', $sHigh), $high);

echo $total . PHP_EOL;

error_log(microtime(1) - $start);
