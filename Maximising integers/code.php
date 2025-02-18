<?php

for($i = 0; $i < 10; ++$i) {
    for($j = 0; $j < 10; ++$j) {
        $parity[$i][$j] = (($i ^ $j) & 1) == 1;
    }
}

$N = stream_get_line(STDIN, 901 + 1, "\n");

$length = strlen($N);

for($i = 1; $i < $length; ++$i) {
    $d = $N[$i];

    if($d == 0) continue; //Moving a 0 will never make it bigger

    $switchIndex = null;

    //Check how far we can move this digit to the left
    for($j = $i - 1; $j >= 0; --$j) {
        if($parity[$d][$N[$j]] == false) break;

        if($N[$j] < $d) $switchIndex = $j; //The number only gets better if the digit would be placed before a smaller digit
    }

    //We have an index where the number gets bigger
    if($switchIndex !== null) {
        //Remove the digit
        $N = substr_replace($N, "", $i, 1);

        //Insert the digit
        $N = substr_replace($N, $d, $switchIndex, 0);
    }
}

echo $N . PHP_EOL;
