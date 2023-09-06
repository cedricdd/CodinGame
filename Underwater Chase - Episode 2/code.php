<?php

const MOVES = ["N" => [0, -1], "S" => [0, 1], "W" => [-1, 0], "E" => [1, 0]]; 

$start = microtime(1);

fscanf(STDIN, "%d %d %d", $w, $h, $n);
for ($y = 0; $y < $h; ++$y) {
    $row = trim(fgets(STDIN));

    foreach(str_split($row) as $x => $c) {
        if($c === "X") {
            $startX = $x;
            $startY = $y;
        }

        if($c !== "o") $water[] = [$x, $y];
    }

    $map[] = $row;
}

$sequences[""] = [$startX, $startY, $map];

//Find all the sequences of size N our submarine can do 
for($i = 0; $i < $n; ++$i) {
    $updatedSequences = [];

    foreach($sequences as $name => [$x, $y, $m]) {

        $m[$y][$x] = "o"; //We can't go to the same position multiple time in a sequence

        foreach(MOVES as $direction => [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h && $m[$yu][$xu] !== "o") $updatedSequences[$name . $direction] = [$xu, $yu, $m];
        }
    }

    $sequences = $updatedSequences;
}

$possibilities = 0;
$answer = [];

//For each sequences we check how many starting position are valid
foreach($sequences as $name => $filler) {
    $positions = $water;

    foreach(str_split($name) as $direction) {
        $updatedPositions = [];

        foreach($positions as [$x, $y]) {
            $xu = $x + MOVES[$direction][0];
            $yu = $y + MOVES[$direction][1];

            if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h && $map[$yu][$xu] !== "o") $updatedPositions[] = [$xu, $yu];
        }

        $positions = $updatedPositions;
    }

    $count = count($positions);

    if($count > $possibilities) {
        $possibilities = $count;
        $answer = [$name];
    } elseif($count == $possibilities) $answer[] = $name;
}

sort($answer);

echo implode(" ", $answer) . " " . $possibilities . PHP_EOL;

error_log(microtime(1) - $start);
