<?php

const MOVES = [
    'N' => [0, -1],
    'S' => [0, 1],
    'E' => [1, 0],
    'W' => [-1, 0],
];
const INV_MOVE = ['S' => 'N', 'N' => 'S', 'E' => 'W', 'W' => 'E'];

fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d", $players);
fscanf(STDIN, "%d", $doorCount);
fscanf(STDIN, "%d", $turnCount);

//The 4 corners are pits
$pits = [];
$pits[0][0] = true;
$pits[0][$width - 1] = true;
$pits[$height - 1][0] = true;
$pits[$height - 1][$width - 1] = true;

$turns = [];

for ($i = 0; $i < $players; $i++) {
    fscanf(STDIN, "%d %d", $rX, $rY);

    error_log("Rocket at $rX $rY");

    $rockets[$rY][$rX] = $i;
    $scores[$i] = 0;
}

for ($i = 0; $i < $doorCount; $i++) {
    fscanf(STDIN, "%d %s", $coord, $wall);

    switch($wall) {
        case 'N':
            $doors[] = [$coord, 0, 'S'];
            break;
        case 'S':
            $doors[] = [$coord, $height - 1, 'N'];
            break;
        case 'E':
            $doors[] = [$width - 1, $coord, 'W'];
            break;
        case 'W':
            $doors[] = [0, $coord, 'E'];
            break;
        default: exit("Invalid Wall Info");
    }
}

$cats = [];
$mouses = [];

for ($i = 1; $i <= $turnCount; $i++) {
    fscanf(STDIN, "%d %d %s", $tX, $tY, $direction);

    $historyTurns[$i] = [$tX, $tY, $direction];
    
    foreach($doors as [$x, $y, $d]) {
        $d = $turns[$y][$x] ?? $d;

        if($i % 10 == 0) $cats[$y][$x][$d] = ($cats[$y][$x][$d] ?? 0) + 1;
        else $mouses[$y][$x][$d] = ($mouses[$y][$x][$d] ?? 0) + 1;
    }

    // error_log(var_export($mouses, 1));

    $catsAfterMove = [];
    $mousesAfterMove = [];

    foreach($mouses as $y => $i1) {
        foreach($i1 as $x => $i2) {
            foreach($i2 as $d => $count) {
                $d = $turns[$y][$x] ?? $d;

                $x2 = $x + MOVES[$d][0];
                $y2 = $y + MOVES[$d][1];

                if($i == 1 || $i == 2) error_log("we have $count mouse at $x $y with direction $d moving to $x2 $y2");

                if(isset($pits[$y2][$x2])) continue; //Mouse is dying in a pit
                elseif(isset($rockets[$y2][$x2])) {
                    // error_log("$count mouses reached rocket at $x2 $y2");
                    $scores[$rockets[$y2][$x2]] += $count;
                }
                //The mouse won't get eaten by a cat during the move
                elseif(!isset($cats[$y2][$x2][INV_MOVE[$d]])) {
                    if($d == 'W' && $x2 == 0) $d = 'S';
                    elseif($d == 'S' && $y2 == $height - 1) $d = 'E';
                    elseif($d == 'E' && $x2 == $width - 1) $d = 'N';
                    elseif($d == 'N' && $y2 == 0) $d = 'W';

                    $mousesAfterMove[$y2][$x2][$d] = ($mousesAfterMove[$y2][$x2][$d] ?? 0) + $count;
                }
            }
        }
    }

    foreach($cats as $y => $i1) {
        foreach($i1 as $x => $i2) {
            foreach($i2 as $d => $count) {
                $d = $turns[$y][$x] ?? $d;

                $x2 = $x + MOVES[$d][0];
                $y2 = $y + MOVES[$d][1];

                // error_log("we have $count cat at $x $y with direction $d moving to $x2 $y2");

                if(isset($pits[$y2][$x2])) continue; //Cat is dying in a pit
                elseif(isset($rockets[$y2][$x2])) $scores[$rockets[$y2][$x2]] = max(0, $scores[$rockets[$y2][$x2]] - $count * 10);
                else {
                    unset($mousesAfterMove[$y2][$x2]); //Cat eats all the mouse on that position

                    if($d == 'W' && $x2 == 0) $d = 'S';
                    elseif($d == 'S' && $y2 == $height - 1) $d = 'E';
                    elseif($d == 'E' && $x2 == $width - 1) $d = 'N';
                    elseif($d == 'N' && $y2 == 0) $d = 'W';

                    $catsAfterMove[$y2][$x2][$d] = ($catsAfterMove[$y2][$x2][$d] ?? 0) + $count;
                }
            }
        }
    }

    // error_log(var_export($mousesAfterMove, 1));

    //Arrows cannot be placed onto another arrow, a rocket, or a pit
    if(!isset($pits[$tY][$tX]) && !isset($rockets[$tY][$tX]) && !isset($turns[$tY][$tX])) {
        $turns[$tY][$tX] = $direction;

        error_log("Turn $i - at $tX $tY turns to $direction");
    }

    if(isset($historyTurns[$i - ($players * 3)])) {
        // error_log(var_export($historyTurns[$i - ($players * 3)], 1));

        [$x, $y, ] = $historyTurns[$i - ($players * 3)];

        error_log("we need to remove turn at $x $y");

        unset($turns[$y][$x]);
    }

    $mouses = $mousesAfterMove;
    $cats = $catsAfterMove;
}

echo implode(PHP_EOL, $scores);
