<?php

//Pre-compute the # of letters at a distance of X from Y
foreach(range("a", "z") as $indexLetter => $letter) {
    for($i = 0; $i < 26; ++$i) {
        if($i == 0) $alphabet[$letter][$i] = 1;
        else $alphabet[$letter][$i] = ($i <= $indexLetter) + ($i <= 25 - $indexLetter);
    }
}

fscanf(STDIN, "%d", $radius);
$center = trim(fgets(STDIN));

function solve(string $center, int $index, $radius): int {
    global $alphabet;
    static $history = [];

    if($index == strlen($center)) return 1;

    if(isset($history[$index][$radius])) return $history[$index][$radius];

    $history[$index][$radius] = 0;

    for($i = 0; $i <= min($radius, 25); ++$i) {
        $history[$index][$radius] += $alphabet[$center[$index]][$i] * solve($center, $index + 1, $radius - $i);
    }

    return $history[$index][$radius];
}

echo solve($center, 0, $radius) . PHP_EOL;
