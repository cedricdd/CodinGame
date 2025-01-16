<?php

fscanf(STDIN, "%d", $number);

$x = 1;

while(true) {
    if($number <= $x * $x) break;

    ++$x;
}

$p = $x - 1;
$n = $x + 1;
$t = $x * 2 - 1;
$m = ($p ** 2) + ceil($t / 2);

$left = $right = $top = $bottom = "-";

if($x & 1) {
    //It's not the first of the row
    if($number != $x ** 2) {
        if($number >= $m) $left = $number + 1;
        else $left = $p ** 2 - ($number - $p ** 2 - 1);
    }

    //It's not the first of the column
    if($number != $p ** 2 + 1) {
        if($number <= $m) $top = $number - 1;
        else $top = ($p - 1) ** 2 + ($x ** 2 - $number + 1);
    }

    if($number < $m) $bottom = $number + 1;
    else $bottom = $x ** 2 + ($x ** 2 - $number + 1);

    if($number > $m) $right = $number - 1;
    else $right = $n ** 2 - ($number - $p ** 2 - 1);

} else {
    //It's not the first of the row
    if($number != $p ** 2 + 1) {
        if($number <= $m) $left = $number - 1;
        else $left = ($p - 1) ** 2 + ($x ** 2 - $number + 1);
    }

    //It's not the first of the column
    if($number != $x ** 2) {
        if($number >= $m) $top = $number + 1;
        else $top = $p ** 2 - ($number - $p ** 2 - 1);
    }

    if($number > $m) $bottom = $number - 1;
    else $bottom = $n ** 2 - ($number - $p ** 2 - 1);

    if($number < $m) $right = $number + 1;
    else $right = $x ** 2 + ($x ** 2 - $number + 1);
}

echo "$top,$bottom,$left,$right" . PHP_EOL;
