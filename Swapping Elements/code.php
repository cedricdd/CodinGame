<?php

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $s = stream_get_line(STDIN, 1000 + 1, "\n");

    // It's a string, get the sum of the ASCII values
    if(!is_numeric($s)) {
        $sum = 0;

        foreach(str_split($s) as $c) $sum += ord($c);

        $inputs[] = $sum;
    } else {
        $inputs[] = $s;
    }
}

if(count(array_unique($inputs)) != $n) exit("-1");

$sorted = $inputs;
sort($sorted);

$swap = 0;

foreach($inputs as $i => &$v) {
    // The value is currently not properly placed, we need to swap
    if($sorted[$i] != $v) {
        $j = array_search($sorted[$i], $inputs);

        $inputs[$j] = $v;
        $inputs[$i] = $sorted[$i];
        ++$swap;
    }
}

echo $swap . PHP_EOL;
