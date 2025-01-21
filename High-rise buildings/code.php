<?php

function solve(array $possibilities, array $counts, array $cells) {
    global $updates, $N;

    if(!$counts) {
        error_log(var_export(implode(PHP_EOL, array_map(function($line) {
            return implode(" ", $line);
        }, $cells)), 1));

        return;
    }

    //Work on the position with the less possibilites
    $bestIndex = null;
    $bestCount = PHP_INT_MAX;

    foreach($counts as $index => $count) {
        if($count < $bestCount) {
            $bestCount = $count;
            $bestIndex = $index;
        }
    }

    error_log("working $bestIndex - $bestCount");

    foreach($possibilities[$bestIndex] as $value => $filler) {
        error_log("using $value");

        $possibilities2 = $possibilities;
        $counts2 = $counts;
        $cells2 = $cells;

        unset($possibilities2[$bestIndex]);
        unset($counts2[$bestIndex]);

        foreach($updates[$bestIndex] as $updateIndex) {
            if(isset($possibilities2[$updateIndex][$value])) {
                unset($possibilities2[$updateIndex][$value]);

                if(--$counts2[$updateIndex] == 0) continue 2;
            }
        }

        $cells2[intdiv($bestIndex, $N)][$bestIndex % $N] = $value;

        solve($possibilities2, $counts2, $cells2);
    }
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);

for($y = 0; $y < $N; ++$y) {
    for($x = 0; $x < $N; ++$x) {
        $index = $y * $N + $x;

        $possibilities[$index] = array_fill(1, $N, 1);

        for($y2 = $y - 1; $y2 >= 0; --$y2) $updates[$index][] = $y2 * $N + $x; //To the top
        for($y2 = $y + 1; $y2 < $N; ++$y2) $updates[$index][] = $y2 * $N + $x; //To the bottom
        for($x2 = $x - 1; $x2 >= 0; --$x2) $updates[$index][] = $y * $N + $x2; //To the left
        for($x2 = $x + 1; $x2 < $N; ++$x2) $updates[$index][] = $y * $N + $x2; //To the right
    }
}

// error_log(var_export($updates, 1));

$canSeeFromNorth = explode(" ", trim(fgets(STDIN)));

foreach($canSeeFromNorth as $x => $value) {
    for($i = 0; $i < $N; ++$i) {
        if($value <= $i + 1) continue 2;

        for($y = 0; $y < $value - $i - 1; ++$y) {
            unset($possibilities[$y * $N + $x][$N - $i]);
        }
    }
}

$canSeeFromWest = explode(" ", trim(fgets(STDIN)));

foreach($canSeeFromWest as $y => $value) {
    for($i = 0; $i < $N; ++$i) {
        if($value <= $i + 1) continue 2;

        for($x = 0; $x < $value - $i - 1; ++$x) {
            unset($possibilities[$y * $N + $x][$N - $i]);
        }
    }
}

$canSeeFromEast = explode(" ", trim(fgets(STDIN)));

foreach($canSeeFromEast as $y => $value) {
    for($i = 0; $i < $N; ++$i) {
        if($value <= $i + 1) continue 2;

        for($x = 1; $x < $value - $i; ++$x) {
            unset($possibilities[$y * $N + ($N - $x)][$N - $i]);
        }
    }
}

$canSeeFromSouth = explode(" ", trim(fgets(STDIN)));

foreach($canSeeFromSouth as $x => $value) {
    for($i = 0; $i < $N; ++$i) {
        if($value <= $i + 1) continue 2;

        for($y = 1; $y < $value - $i; ++$y) {
            unset($possibilities[($N - $y) * $N + $x][$N - $i]);
        }
    }
}

// error_log(var_export($possibilities, 1));

for ($y = 0; $y < $N; ++$y) {
    $cells[] = explode(" ", trim(fgets(STDIN)));
}

foreach($possibilities as $index => $list) $counts[$index] = count($list);

solve($possibilities, $counts, $cells);

error_log(microtime(1) - $start);
