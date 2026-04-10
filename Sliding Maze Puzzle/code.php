<?php

function solve(string $hash, string $moves) {
    global $waterMoves, $playerMoves, $playerMovesToCheck, $waterCanSlide;

    $playerIndex = $hash[9];
    $waterIndex = $hash[10];
    $tileIndex = $hash[$playerIndex];

    //Moving the player
    foreach(($playerMovesToCheck[$playerIndex][$tileIndex] ?? []) as $indexToCheck => $_) {
        if(isset($playerMoves[$playerIndex][$tileIndex][$indexToCheck][$hash[$indexToCheck]])) {
            error_log("Player can move to $indexToCheck");
        }
    }

    //Moving the water
    if($waterCanSlide[$tileIndex]) {
        foreach($waterMoves[$waterIndex] as $waterIndexMoved => $_) {
            if($waterIndexMoved == $playerIndex) continue;

            error_log("water from $waterIndex can be switched with $waterIndexMoved");
        }
    }
}

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
$playerMoves = [];

//Get the position of the water
foreach($tiles as $tileIndex => $tile) {
    if($tile[0] == "~~~") {
        $waterPosition = $tileIndex;

        unset($tiles[$waterPosition]);
    }

    if($tile[1][1] == '.') $waterCanSlide[$tileIndex] = true;
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
                    if($tile[1][0] == '=' && ($tile2[1][2] == '=' || $tile2[1][2] == '+')) $playerMoves[$index][$tileIndex][$index - 1][$tileIndex2] = '1';
                    //We are on the first floor, need to stay there
                    if($tile[1][0] == '.' && $tile2[1][2] == '.') $playerMoves[$index][$tileIndex][$index - 1][$tileIndex2] = '1';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[1][0] == '+' && ($tile2[1][2] == '='  || $tile2[1][2] == '+')) $playerMoves[$index][$tileIndex][$index - 1][$tileIndex2] = '1';
                }
            }

            $waterMoves[$index][$index - 1] = true;
        }

        //Player could move right
        if($x < 2) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[1][2] == '=' && ($tile2[1][0] == '=' || $tile2[1][0] == '+')) $playerMoves[$index][$tileIndex][$index + 1][$tileIndex2] = '2';
                    //We are on the first floor, need to stay there
                    if($tile[1][2] == '.' && $tile2[1][0] == '.') $playerMoves[$index][$tileIndex][$index + 1][$tileIndex2] = '2';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[1][2] == '+' && ($tile2[1][0] == '='  || $tile2[1][0] == '+')) $playerMoves[$index][$tileIndex][$index + 1][$tileIndex2] = '2';
                }
            }

            $waterMoves[$index][$index + 1] = true;
        }

        //Player could move up
        if($y > 0) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[0][1] == '=' && ($tile2[2][1] == '=' || $tile2[2][1] == '+')) $playerMoves[$index][$tileIndex][$index - 3][$tileIndex2] = '3';
                    //We are on the first floor, need to stay there
                    if($tile[0][1] == '.' && $tile2[2][1] == '.') $playerMoves[$index][$tileIndex][$index - 3][$tileIndex2] = '3';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[0][1] == '+' && ($tile2[2][1] == '='  || $tile2[2][1] == '+')) $playerMoves[$index][$tileIndex][$index - 3][$tileIndex2] = '3';     
                }
            }

            $waterMoves[$index][$index - 3] = true;
        }

        //Player could move down
        if($y < 2) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[2][1] == '=' && ($tile2[0][1] == '=' || $tile2[0][1] == '+')) $playerMoves[$index][$tileIndex][$index + 3][$tileIndex2] = '0';
                    //We are on the first floor, need to stay there
                    if($tile[2][1] == '.' && $tile2[0][1] == '.') $playerMoves[$index][$tileIndex][$index + 3][$tileIndex2] = '0';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[2][1] == '+' && ($tile2[0][1] == '='  || $tile2[0][1] == '+')) $playerMoves[$index][$tileIndex][$index + 3][$tileIndex2] = '0';     
                }
            }

            $waterMoves[$index][$index + 3] = true;
        }
    }
}

//For each position, with each tile we want the other positions where the player could possibly move
foreach($playerMoves as $index1 => $list1) {
    foreach($list1 as $tileIndex => $list2) {
        foreach($list2 as $index2 => $_) $playerMovesToCheck[$index1][$tileIndex][$index2] = true;
    }
}

// for($i = 0; $i < 9; ++$i) {
//     error_log("if player is at pos $i"); 

//     foreach(($playerMovesToCheck[$i][$hash[$i]] ?? []) as $index => $_) {
//         error_log("we need to check $index");

//         if(isset($playerMoves[$i][$hash[$i]][$index][$hash[$index]])) error_log("we can move there");
//         else error_log("we CAN'T move there");
//     }
// }

solve($hash, "");

error_log(microtime(1) - $start);
