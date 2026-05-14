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

    $rockets[$rY][$rX] = $i;
    $scores[$i] = 0;
}

//Get all the doors where new animals enter the grid
for ($i = 0; $i < $doorCount; $i++) {
    fscanf(STDIN, "%d %s", $coord, $wall);

    switch($wall) {
        case 'N':
            $doors[] = [$coord, -1, 'S'];
            break;
        case 'S':
            $doors[] = [$coord, $height, 'N'];
            break;
        case 'E':
            $doors[] = [$width, $coord, 'W'];
            break;
        case 'W':
            $doors[] = [-1, $coord, 'E'];
            break;
        default: exit("Invalid Wall Info");
    }
}

$cats = [];
$mouses = [];

for ($i = 0; ;$i++) {
    //An animal is produced behind each door
    foreach($doors as [$x, $y, $d]) {
        if(($i + 1) % 10 == 0) $cats[$y][$x][$d] = ($cats[$y][$x][$d] ?? 0) + 1;
        else $mouses[$y][$x][$d] = ($mouses[$y][$x][$d] ?? 0) + 1;
    }

    $catsAfterMove = [];
    $mousesAfterMove = [];

    //All mouses move forward one square
    foreach($mouses as $y => $i1) {
        foreach($i1 as $x => $i2) {
            foreach($i2 as $d => $count) {
                $x2 = $x + MOVES[$d][0];
                $y2 = $y + MOVES[$d][1];

                if(isset($pits[$y2][$x2])) continue; //Mouse is dying in a pit
                elseif(isset($rockets[$y2][$x2])) $scores[$rockets[$y2][$x2]] += $count; //Mouse enters a rocket
                //The mouse won't get eaten by a cat during the move
                elseif(!isset($cats[$y2][$x2][INV_MOVE[$d]])) {
                    //Check if the mouse is redirected by a wall
                    if($d == 'W' && $x2 == 0) $d = 'S';
                    elseif($d == 'S' && $y2 == $height - 1) $d = 'E';
                    elseif($d == 'E' && $x2 == $width - 1) $d = 'N';
                    elseif($d == 'N' && $y2 == 0) $d = 'W';

                    $mousesAfterMove[$y2][$x2][$d] = ($mousesAfterMove[$y2][$x2][$d] ?? 0) + $count;
                }
            }
        }
    }

    //All cats move forward one square
    foreach($cats as $y => $i1) {
        foreach($i1 as $x => $i2) {
            foreach($i2 as $d => $count) {
                $x2 = $x + MOVES[$d][0];
                $y2 = $y + MOVES[$d][1];

                if(isset($pits[$y2][$x2])) continue; //Cat is dying in a pit
                elseif(isset($rockets[$y2][$x2])) $scores[$rockets[$y2][$x2]] = max(0, $scores[$rockets[$y2][$x2]] - $count * 10); //Cat enters a rocket
                else {
                    unset($mousesAfterMove[$y2][$x2]); //Cat eats all the mouse on that position

                    //Check if the cat is redirected by a wall
                    if($d == 'W' && $x2 == 0) $d = 'S';
                    elseif($d == 'S' && $y2 == $height - 1) $d = 'E';
                    elseif($d == 'E' && $x2 == $width - 1) $d = 'N';
                    elseif($d == 'N' && $y2 == 0) $d = 'W';

                    $catsAfterMove[$y2][$x2][$d] = ($catsAfterMove[$y2][$x2][$d] ?? 0) + $count;
                }
            }
        }
    }

    if($i == $turnCount) break;
    
    //All animals on an arrow are redirected
    foreach($turns as [$x, $y, $d]) {
        if(isset($mousesAfterMove[$y][$x])) {
            $count = 0;

            foreach($mousesAfterMove[$y][$x] as $c) $count += $c;

            $mousesAfterMove[$y][$x] = [$d => $count];
        }

        if(isset($catsAfterMove[$y][$x])) {
            $count = 0;

            foreach($catsAfterMove[$y][$x] as $c) $count += $c;

            $catsAfterMove[$y][$x] = [$d => $count];
        }
    }

    unset($turns[$i - ($players * 3)]); //Each player can only have 3 arrows at the same time

    fscanf(STDIN, "%d %d %s", $tX, $tY, $direction);

    $turns[$i] = [$tX, $tY, $direction];
    $mouses = $mousesAfterMove;
    $cats = $catsAfterMove;
}

echo implode(PHP_EOL, $scores);
