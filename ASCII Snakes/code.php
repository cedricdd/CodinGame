<?php

$outputD = [['+', '-', '+'], ['|', ' ', '|']];
$outputU = [['|', ' ', '|'], ['+', '-', '+']];
$outputR = [['+', '-', '-'], ['+', '-', '-']];
$outputL = [['-', '-', '+'], ['-', '-', '+']];

$info = [
    'R' => [
        'D' => [1, 1, "| ++--", 3, 0],
        'U' => [-1, 1, "| ++--", 3, -1],
        'R' => [1, 1, "------", 3, 0],
    ],
    'D' => [
        'R' => [1, 1, "--++ |", 0, 2],
        'L' => [1, -1, "--++ |", -2, 2],
        'D' => [1, 1, "| || |", 0, 2],
    ],
    'L' => [
        'D' => [1, 1, "+ |--+", -1, 0],
        'U' => [-1, 1, "+ |--+", -1, -1],
        'L' => [1, -1, "------", -3, 0],
    ],
    'U' => [
        'R' => [1, 1, "+ |--+", 0, -1],
        'U' => [-1, 1, "| || |", 0, -2],
        'L' => [1, -1, "+ |--+", -2, -1],
    ],
    'X' => [
        'D' => [1, 1, "| |+-+", 0, 0],
        'R' => [1, 1, "--+--+", 0, 0],
        'L' => [1, -1, "--+--+", 0, 0],
        'U' => [-1, 1, "| |+-+", 0, 0],
    ],
];

foreach(str_split(trim(fgets(STDIN)) . "X") as $i => $direction) {
    if($i == 0) {
        switch($direction) {
            case 'D': $output = $outputD; $x = 0; $y = 2; break;
            case 'U': $output = $outputU; $x = 0; $y = -1; break;
            case 'R': $output = $outputR; $x = 3; $y = 0; break;
            case 'L': $output = $outputL; $x = -1; $y = 0; break;
        }
    } else {
        [$a, $b, $c, $d, $e] = $info[$direction][$prevDirection];

        $output[$y][$x] = $c[0];
        $output[$y][$x + $b] = $c[1];
        $output[$y][$x + $b + $b] = $c[2];
        $output[$y + $a][$x] = $c[3];
        $output[$y + $a][$x + $b] = $c[4];
        $output[$y + $a][$x + $b + $b] = $c[5];

        $x += $d;
        $y += $e;
    }

    $prevDirection = $direction;
}

ksort($output);

$minX = 0;
$maxX = 0;

foreach($output as $i => $line) {
    ksort($line);

    if(array_key_first($line) < $minX) $minX = array_key_first($line);
    if(array_key_last($line) > $maxX) $maxX = array_key_last($line);

    $output[$i] = $line;
}

foreach($output as $i => $line) {
    $l = str_repeat(" ", $maxX - $minX + 1);

    foreach($line as $x => $c) $l[$x] = $c;

    echo rtrim($l) . PHP_EOL;
}
