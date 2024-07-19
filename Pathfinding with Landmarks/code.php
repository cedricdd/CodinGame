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
        $grid[$y * $width + $x] = $c;
    }
}

$total = 0;
$groups = [];
$visited = [];

for($y = $height - 1; $y > 0; --$y) {
    for($x = $width - 1; $x > 0; --$x) {
        $index = $y * $width + $x;

        if($grid[$index] == '.' && !isset($visited[$index])) {
            error_log("starting at $index - $x $y");

            $toCheck = [$index];
            $group = [];

            while($toCheck) {
                $index = array_pop($toCheck);

                if(isset($visited[$index])) continue;
                else $visited[$index] = 1;

                $group[$index] = INF;

                foreach([-$width - 1, -$width, -$width + 1, -1, 1, $width - 1, $width, $width + 1] as $move) {
                    if($grid[$index + $move] == '.') $toCheck[] = $index + $move;
                }
            }

            $count = count($group);

            error_log("found a group of $count");

            if($count >= 50) {
                $total += $count;
                $groups[] = [$count, $group];
            }
        }
    }
}

usort($groups, function($a, $b) {
    return $b[0] <=> $a[0];
});


foreach($groups as $i => [$count, $group]) {
    $landmark = max(1, intval($landmarksNum * ($count / $total)));

    error_log("using $landmark for group $i - $count $total - " . ($count/$total));

    foreach(selectLandmarks($group, $landmark) as $index) {
        echo ($index % $width) . " " . intdiv($index, $width) . PHP_EOL;
    }

    $landmarksNum -= $landmark;
    $total -= $count;

    if($landmarksNum == 0) break;
}

error_log(microtime(1) - $start);
