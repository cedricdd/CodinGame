<?php

function testDate(int $a, int $b) {
    $date = $a * $b;

    if(strlen($date) > 8) return null; //Too long to be a date

    $date = str_pad($date, 8, '0', STR_PAD_LEFT);

    $y = substr($date, 0, 4);
    $m = substr($date, 4, 2);
    $d = substr($date, 6, 2);

    if($d == 0 || $d > 31) return null; //Date value is wrong
    if($m == 0 || $m > 12) return null; //Month value is wrong

    //Make sure the two factors are the ones who minimize the absolute value
    for($i = ceil(sqrt($date)); $i >= 1; --$i) {
        if($date % $i == 0) {
            if($i != $a && $i != $b) return null;

            break;
        }
    }

    return "{$y}-{$m}-{$d}";
}

fscanf(STDIN, "%d", $n);

$l = strlen($n);

for($i = 1; $i < $l; ++$i) {
    if(($date = testDate(substr($n, 0, $i), substr($n, $i))) !== null) exit($date);
}
