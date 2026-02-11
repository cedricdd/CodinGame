<?php

fscanf(STDIN, "%d", $n);
$path[0] = stream_get_line(STDIN, $n + 1, "\n");
$path[1] = stream_get_line(STDIN, $n + 1, "\n");
$blank = str_repeat("o", $n);

error_log($path[0] . "\n" . $path[1] . "\n");

$turn = 1;

while(true) {
    $updatedPath = [$blank, $blank];
    $moves = [];
    $pedestrians = [];

    for($i = 0; $i < $n; ++$i) {
        if($path[0][$i] != 'o') {
            $pedestrians[0][$i] = 1;

            if($path[0][$i] == 'R') {
                //The first move is going right
                $moves[0][$i + 1][] = [0, $i, 1];
            } elseif($path[0][$i] == 'L') {
                //The first move is going down
                $moves[1][$i][] = [0, $i, 2];

                //The fallback is going left
                $moves[0][$i - 1][] = [0, $i, 3];
            }
        }

        if($path[1][$i] != 'o') {
            $pedestrians[1][$i] = 1;

            if($path[1][$i] == 'L') {
                //The first move is going left
                $moves[1][$i - 1][] = [1, $i, 1];
            } elseif($path[1][$i] == 'R') {
                //The first move is going up
                $moves[0][$i][] = [1, $i, 2];

                //The fallback is going right
                $moves[1][$i + 1][] = [1, $i, 3];
            }
        }
    }

    // error_log(var_export($moves, 1));

    //Move everything with priority 1
    foreach($moves as $line => $list) {
        foreach($list as $index => $candidates) {
            foreach($candidates as [$cLine, $cIndex, $priority]) {
                if($priority == 1) {
                    if($index >= 0 && $index < $n) $updatedPath[$line][$index] = $path[$cLine][$cIndex];

                    unset($moves[$line][$index]);
                    unset($pedestrians[$cLine][$cIndex]);

                    continue 2;
                }
            }
        }
    }

    error_log("Step 1:");
    error_log($updatedPath[0] . "\n" . $updatedPath[1] . "\n");

    //Move everything with priority 2
    foreach($moves as $line => $list) {
        foreach($list as $index => $candidates) {
            foreach($candidates as [$cLine, $cIndex, $priority]) {
                if($priority == 2 && isset($pedestrians[$cLine][$cIndex])) {
                    // error_log("level 2 moving $cLine $cIndex to $line $index");

                    $updatedPath[$line][$index] = $path[$cLine][$cIndex];

                    unset($moves[$line][$index]);
                    unset($pedestrians[$cLine][$cIndex]);

                    $moved[$cLine][$cIndex] = 1;

                    continue 2;
                }
            }
        }
    }

    error_log("Step 2:");
    error_log($updatedPath[0] . "\n" . $updatedPath[1] . "\n");

    //Move everything with priority 3
    foreach($moves as $line => $list) {
        foreach($list as $index => $candidates) {
            foreach($candidates as [$cLine, $cIndex, $priority]) {
                if($priority == 3 && isset($pedestrians[$cLine][$cIndex])) {
                    // error_log("level 3 moving $cLine $cIndex to $line $index");

                    if($index >= 0 && $index < $n) $updatedPath[$line][$index] = $path[$cLine][$cIndex];

                    unset($pedestrians[$cLine][$cIndex]);

                    continue 2;
                }
            }
        }
    }

    error_log("Step 3:");
    error_log($updatedPath[0] . "\n" . $updatedPath[1] . "\n");

    //The ones that can't move this turn
    foreach($pedestrians as $line => $list) {
        foreach($list as $index => $_) {
            $updatedPath[$line][$index] = $path[$line][$index];
        }
    }

    $path = $updatedPath;

    error_log("Step 4:");
    error_log($path[0] . "\n" . $path[1] . "\n");

    // die();

    if($path[0] == $blank && $path[1] == $blank) break;

    if(++$turn == 20) break;
}

echo $turn . PHP_EOL;
