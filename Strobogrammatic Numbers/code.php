<?php

const SINGLE = [0, 1, 8];
const PAIR = [[0, 0], [1, 1], [6, 9], [8, 8], [9, 6]];

function isStrobogrammiticNumber(string $number): int {
    if(strrev($number) == strtr($number, "01689", "01986")) return 1;
    else return 0;
}

function getCountTotal(int $size, bool $isInside = false): int {
    $count = (($size & 1) == 0) ? 1 : 3;

    // error_log("start with $count -- $size");

    for($i = ($size >> 1); $i > 0; --$i) {
        if($i == 1 && $isInside == false) $count *= 4;
        else $count *= 5;
    }

    error_log("2 with $size with have " . $count);
    return $count;
}

function getCountUpTo(int $size, int $max, bool $isInside = false): int {
    $count = 0;
    $pair = [[0, 0], [1, 1], [6, 9], [8, 8], [9, 6]];

    if($isInside) array_shift($pair);

    $firstDigit = strval($max)[0];

    error_log("getCountUpTo - $size - $max - $firstDigit");

    $full = $size > 2 ? getCountTotal($size - 2, true) : 1;

    error_log("full is $full");

    foreach($pair as [$start, $end]) {
        if($start < $firstDigit) {
            $count += $full;
            error_log("$start < " . $firstDigit);
        }
        elseif($start == $firstDigit) {
            if($start == $max) $count += 1;
            else $count += getCountUpTo($size - 2, intval(substr($max, 1, -1)));
        }
        elseif($start > $firstDigit) break;
    }

    return $count;
}

$start = microtime(1);

$low = stream_get_line(STDIN, 4096 + 1, "\n");
$high = stream_get_line(STDIN, 4096 + 1, "\n");

error_log("$low $high");

if($low == $high) {
    echo isStrobogrammiticNumber(strval($low)) . PHP_EOL;
    exit();
}

$sLow = strlen($low);
$sHigh = strlen($high);

$total = getCountUpTo($sLow, $low, true) * -1;

error_log("initial is $total");

//Add everything where we count all the numbers of size $size
for($size = $sLow; $size < $sHigh; ++$size) {
    $check = getCountTotal($size);

    $total += $check;

    error_log("size is $size -- check is $check -- total is $total");
}

echo $total + getCountUpTo($sHigh, $high, true) . PHP_EOL;

error_log(microtime(1) - $start);
