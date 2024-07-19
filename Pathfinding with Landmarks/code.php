<?php

const SQRT2 = 1.41421356237;

function floodFill(array &$distances, int $index) {
    global $grid, $width, $height;

    $visited = [];
    $toCheck[$index] = 0.0;

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as $index => $count) {
            if(isset($visited[$index])) continue;
            else $visited[$index] = 1;

            if($count < $distances[$index]) $distances[$index] = $count;

            foreach([1, -1, $width, -$width] as $move) {
                $newIndex = $index + $move;

                if($grid[$newIndex] == '.') {
                    if(!isset($newCheck[$newIndex]) || $newCheck[$newIndex] > $count + 1) $newCheck[$newIndex] = $count + 1;
                }
            }

            foreach([-$width - 1, -$width + 1, $width - 1, $width + 1] as $move) {
                $newIndex = $index + $move;

                if($grid[$newIndex] == '.') {
                    if(!isset($newCheck[$newIndex]) || $newCheck[$newIndex] > $count + SQRT2) $newCheck[$newIndex] = $count + SQRT2;
                }
            }
        }

        $toCheck = $newCheck;
    }
}

function selectLandmarks(array $distances, int $n): array {
    $selected[] = array_key_first($distances);

    // error_log(var_export($distances, true));
  
    while(($count = count($selected)) < $n) {
        floodFill($distances, end($selected));

        asort($distances);

        $selected[] = array_key_last($distances);
    }

    return $selected;
}

fscanf(STDIN, "%d %f", $landmarksNum, $efficiency);
fscanf(STDIN, "%d %d", $width, $height);

$start = microtime(1);

error_log("$landmarksNum, $efficiency");
error_log("$width, $height");

$points = [];

for ($y = 0; $y < $height; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if($c == '.') {
            $index = $y * $width + $x;

            $distances[$index] = INF;
        }

        $grid[] = $c;
    }
}

$selected = selectLandmarks($distances, $landmarksNum);

foreach($selected as $index) {
    echo ($index % $width) . " " . intdiv($index, $width) . PHP_EOL;
}

error_log(microtime(1) - $start);
