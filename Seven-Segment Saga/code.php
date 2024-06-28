<?php

const POS = [[0, 1, "_"], [1, 0, '|'], [1, 2, '|'], [1, 1, '_'], [2, 0, '|'], [2, 2, '|'], [2, 1, '_']];

$occurences =  array_fill(0, 7, 0);
$output = array_fill(0, 3, "   ");

for($i = 0; $i < 3; ++$i) $inputs[] = stream_get_line(STDIN, 19 + 1, "\n");

for($i = 0; $i < 5; ++$i) {
    $start = $i * 4;

    foreach(POS as $j => [$y, $x, $c]) {
        if($inputs[$y][$start + $x] == $c) $occurences[$j]++;
    }
}

foreach($occurences as $i => $count) {
    if($count == 5) {
        [$y, $x, $c] = POS[$i];
        $output[$y][$x] = $c;
    }
}

echo implode("\n", $output) . PHP_EOL;
