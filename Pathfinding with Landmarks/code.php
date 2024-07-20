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

function splitLandmarks(array &$groups, int $n) {

    usort($groups, function($a, $b) {
        return $b[0] <=> $a[0];
    });

    //We try to add at least 2 in each groups
    // if($n >= count($groups) * 2) $min = 2;
    // else $min = 1;

    // foreach($groups as $i => $filler) {
    //     $groups[$i][2] += $min;

    //     if(($n -= $min) <= 0) return;
    // }

    $total = array_sum(array_column($groups, 0));
    $landmarks = 0;

    foreach($groups as $i => [$tiles, ,]) {
        $value = $n * ($tiles / $total);

        error_log(($tiles / $total) . " " . $n * ($tiles / $total));

        $groups[$i][2] += floor($value);
        $groups[$i][3] = $value - floor($value);

        $landmarks += floor($value);
    }

    if(($n -= $landmarks) > 0) {
        usort($groups, function($a, $b) {
            return $b[3] <=> $a[3];
        });

        for($i = 0; $i < $n; ++$i) $groups[$i][2] += 1;
    }
}

fscanf(STDIN, "%d %f", $landmarksNum, $efficiency);
fscanf(STDIN, "%d %d", $width, $height);

$start = microtime(1);

error_log("$landmarksNum, $efficiency");
error_log("$width, $height");

$points = [];

for ($y = 0; $y < $height; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        $grid[$y * $width + $x] = $c;
    }
}

$groups = [];
$visited = [];
$threshold = min(500, ($width - 1) * ($height - 1) * 0.05);

error_log("threshold is $threshold");

for($y = $height - 1; $y > 0; --$y) {
    for($x = $width - 1; $x > 0; --$x) {
        $index = $y * $width + $x;

        if($grid[$index] == '.' && !isset($visited[$index])) {
            // error_log("starting at $index - $x $y");

            $toCheck = [$index];
            $distances = [];

            while($toCheck) {
                $index = array_pop($toCheck);

                if(isset($visited[$index])) continue;
                else $visited[$index] = 1;

                $distances[$index] = INF;

                foreach([-$width - 1, -$width, -$width + 1, -1, 1, $width - 1, $width, $width + 1] as $move) {
                    if($grid[$index + $move] == '.') $toCheck[] = $index + $move;
                }
            }

            $count = count($distances);

            error_log("found a group of $count");

            if($count >= $threshold) {
                $groups[] = [$count, $distances, 0];
            }
        }
    }
}

splitLandmarks($groups, $landmarksNum);

foreach($groups as $i => [$count, $group, $landmarks]) {
    error_log("group $i - $count - $landmarks");

    if($landmarks == 0) continue;

    foreach(selectLandmarks($group, $landmarks) as $index) {
        echo ($index % $width) . " " . intdiv($index, $width) . PHP_EOL;
    }
}

error_log(microtime(1) - $start);
