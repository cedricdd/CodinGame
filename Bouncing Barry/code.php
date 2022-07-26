<?php

$directions = fgetcsv(STDIN, 0, " ");
$bounces = fgetcsv(STDIN, 0, " ");

$x = 0;
$y = 0;
$positions = [];
$cardinal = ['N' => [0, -1], 'S' => [0, 1], 'W' => [-1, 0], 'E' => [1, 0]];

foreach($directions as $key => $direction) {
    list($xm, $ym) = $cardinal[$direction];

    for($i = 0; $i < $bounces[$key]; ++$i) {
        $x += $xm;
        $y += $ym;

        if(isset($positions[$y][$x])) unset($positions[$y][$x]); //Barry is back on a position he already was
        else $positions[$y][$x] = $x; //We want $x as key to directly unset & $x as value for max() & min()
    }
}

$positions = array_filter($positions); //Remove empty lines

//We need the width & height of the output grid
$maxX = -INF; $minX = INF;

foreach($positions as $y => $line) {
    $maxX = max($maxX, max($line));
    $minX = min($minX, min($line));
}

ksort($positions);
$minY = array_key_first($positions);
$maxY = array_key_last($positions);

//Generate output grid
$grid = array_fill(0, $maxY - $minY + 1, array_fill(0, max($maxX - $minX, 0) + 1, "."));

//Fill output grid with the #
foreach($positions as $y => $line) {
    foreach($line as $x => $v) {
        $grid[$y - $minY][$x - $minX] = "#";
    }
}

//Print output grid
echo implode("\n", array_map(function($line) {
    return implode("", $line);
}, $grid));
?>
