<?php

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

foreach($tiles as $tileIndex => $tile) {
    if($tile[0] == "~~~") {
        $waterPosition = $tileIndex;

        unset($tiles[$waterPosition]);
    }
}

error_log("Player starts at $playerPosition");
error_log("Water starts at $waterPosition");

$playerMoves = [];

// error_log(var_export($tiles, 1));

$hash = implode("", range(0, 9)) . $playerPosition;

for($index = 0, $y = 0; $y < 3; ++$y) {
    for($x = 0; $x < 3; ++$x, ++$index) {
        //Player could move left
        if($x > 0) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[1][0] == '=' && ($tile2[1][2] == '=' || $tile2[1][2] == '+')) $playerMoves[$index][$tileIndex][$index - 1][$tileIndex2] = '<';
                    //We are on the first floor, need to stay there
                    if($tile[1][0] == '.' && $tile2[1][2] == '.') $playerMoves[$index][$tileIndex][$index - 1][$tileIndex2] = '<';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[1][0] == '+' && ($tile2[1][2] == '='  || $tile2[1][2] == '+')) $playerMoves[$index][$tileIndex][$index - 1][$tileIndex2] = '<';
                }
            }
        }

        //Player could move right
        if($x < 2) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[1][2] == '=' && ($tile2[1][0] == '=' || $tile2[1][0] == '+')) $playerMoves[$index][$tileIndex][$index + 1][$tileIndex2] = '>';
                    //We are on the first floor, need to stay there
                    if($tile[1][2] == '.' && $tile2[1][0] == '.') $playerMoves[$index][$tileIndex][$index + 1][$tileIndex2] = '>';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[1][2] == '+' && ($tile2[1][0] == '='  || $tile2[1][0] == '+')) $playerMoves[$index][$tileIndex][$index + 1][$tileIndex2] = '>';
                }
            }
        }

        //Player could move up
        if($y > 0) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[0][1] == '=' && ($tile2[2][1] == '=' || $tile2[2][1] == '+')) $playerMoves[$index][$tileIndex][$index - 3][$tileIndex2] = '^';
                    //We are on the first floor, need to stay there
                    if($tile[0][1] == '.' && $tile2[2][1] == '.') $playerMoves[$index][$tileIndex][$index - 3][$tileIndex2] = '^';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[0][1] == '+' && ($tile2[2][1] == '='  || $tile2[2][1] == '+')) $playerMoves[$index][$tileIndex][$index - 3][$tileIndex2] = '^';     
                }
            }
        }

        //Player could move down
        if($y < 2) {
            foreach($tiles as $tileIndex => $tile) {
                foreach($tiles as $tileIndex2 => $tile2) {
                    if($tileIndex == $tileIndex2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[2][1] == '=' && ($tile2[0][1] == '=' || $tile2[0][1] == '+')) $playerMoves[$index][$tileIndex][$index + 3][$tileIndex2] = 'v';
                    //We are on the first floor, need to stay there
                    if($tile[2][1] == '.' && $tile2[0][1] == '.') $playerMoves[$index][$tileIndex][$index + 3][$tileIndex2] = 'v';
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[2][1] == '+' && ($tile2[0][1] == '='  || $tile2[0][1] == '+')) $playerMoves[$index][$tileIndex][$index + 3][$tileIndex2] = 'v';     
                }
            }
        }
    }
}

error_log(var_export($playerMoves[$playerPosition][$playerPosition], 1));

error_log(microtime(1) - $start);
