<?php

const DIRECTIONS = ["", "v", "<", ">", "^"];

fscanf(STDIN, "%d %d", $R, $C);

$start = microtime(1);
$playerPosition = $R * 3 + $C;

$tiles = [];

for ($y = 0; $y < 9; ++$y) {
    $line = stream_get_line(STDIN, 9 + 1, "\n");

    for($x = 0; $x < 3; ++$x) {
        $tiles[intdiv($y, 3) * 3 + $x][] = substr($line, $x * 3, 3);
    }
}

$waterMoves = [];
$waterCanSlide = array_fill(0, 9, false);
$playerCanLeave = array_fill(0, 9, false);
$playerMoves = [];

//Get the position of the water
foreach($tiles as $tileIndex => $tile) {
    if($tile[0] == "~~~") {
        $waterPosition = $tileIndex;

        unset($tiles[$waterPosition]);
    }

    if($tile[1][1] == '.') $waterCanSlide[$tileIndex] = true; //Water can only move if player is on first floor
    if($tile[1][0] == '=' || $tile[1][0] == '+') $playerCanLeave[$tileIndex] = true; //Player can only exit if he's on the second floor or by using a stair
}

$hash = implode("", range(0, 8)) . $playerPosition . $waterPosition;

error_log("Player starts at $playerPosition");
error_log("Water starts at $waterPosition");
error_log("Hash $hash");

for($index = 0, $y = 0; $y < 3; ++$y) {
    for($x = 0; $x < 3; ++$x, ++$index) {
        //Player could move left
        if($x > 0) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[1][0] == '=' && ($tile2[1][2] == '=' || $tile2[1][2] == '+')) $playerMoves[$index][$tileIndex][$index - 1][$tileIndex2] = '2';
                    //We are on the first floor, need to stay there
                    if($tile[1][0] == '.' && $tile2[1][2] == '.') $playerMoves[$index][$tileIndex][$index - 1][$tileIndex2] = '2';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[1][0] == '+' && ($tile2[1][2] == '='  || $tile2[1][2] == '+')) $playerMoves[$index][$tileIndex][$index - 1][$tileIndex2] = '2';
                }
            }

            $waterMoves[$index][$index - 1] = '3'; //It's the tile moving not the water so we need '>'
        }

        //Player could move right
        if($x < 2) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[1][2] == '=' && ($tile2[1][0] == '=' || $tile2[1][0] == '+')) $playerMoves[$index][$tileIndex][$index + 1][$tileIndex2] = '3';
                    //We are on the first floor, need to stay there
                    if($tile[1][2] == '.' && $tile2[1][0] == '.') $playerMoves[$index][$tileIndex][$index + 1][$tileIndex2] = '3';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[1][2] == '+' && ($tile2[1][0] == '='  || $tile2[1][0] == '+')) $playerMoves[$index][$tileIndex][$index + 1][$tileIndex2] = '3';
                }
            }

            $waterMoves[$index][$index + 1] = '2'; //It's the tile moving not the water so we need '<'
        }

        //Player could move up
        if($y > 0) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[0][1] == '=' && ($tile2[2][1] == '=' || $tile2[2][1] == '+')) $playerMoves[$index][$tileIndex][$index - 3][$tileIndex2] = '4';
                    //We are on the first floor, need to stay there
                    if($tile[0][1] == '.' && $tile2[2][1] == '.') $playerMoves[$index][$tileIndex][$index - 3][$tileIndex2] = '4';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[0][1] == '+' && ($tile2[2][1] == '='  || $tile2[2][1] == '+')) $playerMoves[$index][$tileIndex][$index - 3][$tileIndex2] = '4';     
                }
            }

            $waterMoves[$index][$index - 3] = '1'; //It's the tile moving not the water so we need 'v'
        }

        //Player could move down
        if($y < 2) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[2][1] == '=' && ($tile2[0][1] == '=' || $tile2[0][1] == '+')) $playerMoves[$index][$tileIndex][$index + 3][$tileIndex2] = '1';
                    //We are on the first floor, need to stay there
                    if($tile[2][1] == '.' && $tile2[0][1] == '.') $playerMoves[$index][$tileIndex][$index + 3][$tileIndex2] = '1';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[2][1] == '+' && ($tile2[0][1] == '='  || $tile2[0][1] == '+')) $playerMoves[$index][$tileIndex][$index + 3][$tileIndex2] = '1';     
                }
            }

            $waterMoves[$index][$index + 3] = '4'; //It's the tile moving not the water so we need '^'
        }
    }
}

//For each position, with each tile we want the other positions where the player could possibly move
foreach($playerMoves as $index1 => $list1) {
    foreach($list1 as $tileIndex => $list2) {
        foreach($list2 as $index2 => $_) $playerMovesToCheck[$index1][$tileIndex][$index2] = true;
    }
}

$history = [];
$queue = [[$hash, ""]];
$solution = false;

while($solution == false) {
    $newQueue = [];

    foreach($queue as [$hash, $moves]) {
        //If we have already found this configuration, we skip the duplicate
        if(isset($history[$hash])) continue;
        else $history[$hash] = true;

        $playerIndex = $hash[9];
        $waterIndex = $hash[10];
        $tileIndex = $hash[$playerIndex];

        //Player is on the top left tile and he can exit on this tile
        if($playerIndex == 0 && $playerCanLeave[$tileIndex]) {
            $moves .= "P2";

            //Get the 'best' solution based on lexicography
            if($solution == false) $solution = $moves;
            elseif(strcmp($solution, $moves) > 0) $solution = $moves;

            continue;
        }

        //Moving the player
        foreach(($playerMovesToCheck[$playerIndex][$tileIndex] ?? []) as $indexToCheck => $_) {
            $direction = $playerMoves[$playerIndex][$tileIndex][$indexToCheck][$hash[$indexToCheck]] ?? 0;

            //The player can move
            if($direction) {
                $newHash = $hash;
                $newHash[9] = $indexToCheck;

                $newQueue[] = [$newHash, $moves . 'P' . $direction];
            }
        }

        //Moving a tile
        if($waterCanSlide[$tileIndex]) {
            foreach($waterMoves[$waterIndex] as $waterIndexMoved => $direction) {
                if($waterIndexMoved == $playerIndex) continue;

                //A tile & water can switch
                $newHash = $hash;
                $newHash[$waterIndex] = $hash[$waterIndexMoved];
                $newHash[$waterIndexMoved] = $hash[$waterIndex];
                $newHash[10] = $waterIndexMoved;

                $newQueue[] = [$newHash, $moves . 'T' . $direction];
            }
        }
    }

    $queue = $newQueue;
    unset($newQueue);
}

$len = strlen($solution);

echo ($len / 2) . PHP_EOL;

for($i = 0; $i < $len; $i += 2) {
    echo $solution[$i] . " " . DIRECTIONS[$solution[$i + 1]] . PHP_EOL;
}

error_log(microtime(1) - $start);
