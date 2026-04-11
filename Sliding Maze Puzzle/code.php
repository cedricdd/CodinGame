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
foreach($tiles as $tileID => $tile) {
    if($tile[0] == "~~~") {
        $waterPosition = $tileID;

        unset($tiles[$waterPosition]);
    }

    if($tile[1][1] == '.') $waterCanSlide[$tileID] = true; //Water can only move if player is on first floor
    if($tile[1][0] == '=' || $tile[1][0] == '+') $playerCanLeave[$tileID] = true; //Player can only exit if he's on the second floor or by using a stair
}

$hash = implode("", range(0, 8)) . $playerPosition . $waterPosition;

error_log("Player starts at $playerPosition");
error_log("Water starts at $waterPosition");
error_log("Hash $hash");

for($index = 0, $y = 0; $y < 3; ++$y) {
    for($x = 0; $x < 3; ++$x, ++$index) {
        //Player could move left
        if($x > 0) {
            foreach($tiles as $tileID => $tile) {
                $mask = 0;

                foreach($tiles as $tileID2 => $tile2) {
                    if($tileID == $tileID2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[1][0] == '=' && ($tile2[1][2] == '=' || $tile2[1][2] == '+')) $mask |= 1 << $tileID2;
                    //We are on the first floor, need to stay there
                    if($tile[1][0] == '.' && $tile2[1][2] == '.') $mask |= 1 << $tileID2;
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[1][0] == '+' && ($tile2[1][2] == '='  || $tile2[1][2] == '+')) $mask |= 1 << $tileID2;
                }

                if($mask) $playerMoves[$index][$tileID][$index - 1] = [$mask, '2'];
            }

            $waterMoves[$index][$index - 1] = '3'; //It's the tile moving not the water so we need '>'
        }

        //Player could move right
        if($x < 2) {
            foreach($tiles as $tileID => $tile) {
                $mask = 0;

                foreach($tiles as $tileID2 => $tile2) {
                    if($tileID == $tileID2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[1][2] == '=' && ($tile2[1][0] == '=' || $tile2[1][0] == '+')) $mask |= 1 << $tileID2;
                    //We are on the first floor, need to stay there
                    if($tile[1][2] == '.' && $tile2[1][0] == '.') $mask |= 1 << $tileID2;
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[1][2] == '+' && ($tile2[1][0] == '='  || $tile2[1][0] == '+')) $mask |= 1 << $tileID2;
                }

                if($mask) $playerMoves[$index][$tileID][$index + 1] = [$mask, '3'];
            }

            $waterMoves[$index][$index + 1] = '2'; //It's the tile moving not the water so we need '<'
        }

        //Player could move up
        if($y > 0) {
            foreach($tiles as $tileID => $tile) {
                $mask = 0;

                foreach($tiles as $tileID2 => $tile2) {
                    if($tileID == $tileID2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[0][1] == '=' && ($tile2[2][1] == '=' || $tile2[2][1] == '+')) $mask |= 1 << $tileID2;
                    //We are on the first floor, need to stay there
                    if($tile[0][1] == '.' && $tile2[2][1] == '.') $mask |= 1 << $tileID2;
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[0][1] == '+' && ($tile2[2][1] == '='  || $tile2[2][1] == '+')) $mask |= 1 << $tileID2;    
                }

                if($mask) $playerMoves[$index][$tileID][$index - 3] = [$mask, '4'];
            }

            $waterMoves[$index][$index - 3] = '1'; //It's the tile moving not the water so we need 'v'
        }

        //Player could move down
        if($y < 2) {
            foreach($tiles as $tileID => $tile) {
                $mask = 0;

                foreach($tiles as $tileID2 => $tile2) {
                    if($tileID == $tileID2) continue;

                    //We are on the second floor, need to stay there or use a stair
                    if($tile[2][1] == '=' && ($tile2[0][1] == '=' || $tile2[0][1] == '+')) $mask |= 1 << $tileID2;
                    //We are on the first floor, need to stay there
                    if($tile[2][1] == '.' && $tile2[0][1] == '.') $mask |= 1 << $tileID2;
                    //We are on the first floor and using a stair, need to end up the second floor or another stair need to cancel the change of floor
                    if($tile[2][1] == '+' && ($tile2[0][1] == '='  || $tile2[0][1] == '+')) $mask |= 1 << $tileID2;   
                }

                if($mask) $playerMoves[$index][$tileID][$index + 3] = [$mask, '1'];
            }

            $waterMoves[$index][$index + 3] = '4'; //It's the tile moving not the water so we need '^'
        }
    }
}

//The first 36 bits represent the index of the tiles at each positions
$hash = 36344967696;
$hash |= $playerPosition << 36; //The position of the player
$hash |= $waterPosition << 40; //The position of the water

$history = [];
$queue[1] = [[$hash, ""]];
$solution = null;
$turn = 1;

while($solution == false) {

    foreach($queue[$turn] as [$hash, $moves]) {
        //If we have already found this configuration, we skip the duplicate
        if(isset($history[$hash])) continue;
        else $history[$hash] = true;

        $playerPosition = ($hash >> 36) & 15; 
        $waterPosition = $hash >> 40;
        $tileID = ($hash >> ($playerPosition * 4)) & 15;

        //Player is on the top left tile and he can exit on this tile
        if($playerPosition == 0 && $playerCanLeave[$tileID]) {
            $moves .= "P2";

            //Get the 'best' solution based on lexicography
            if($solution === null || strcmp($solution, $moves) > 0) $solution = $moves;

            continue;
        }

        //Moving the player
        foreach(($playerMoves[$playerPosition][$tileID] ?? []) as $playerPositionAfterMoved => [$mask, $direction]) {
            $tileIDAfterMoved = ($hash >> ($playerPositionAfterMoved * 4)) & 15;

            //The player can move
            if($mask & (1 << $tileIDAfterMoved)) {
                $newHash = $hash;
                $newHash &= ~(15 << 36); //Erase current player position
                $newHash |= $playerPositionAfterMoved << 36; //Set new player position

                $queue[$turn + 1][] = [$newHash, $moves . 'P' . $direction];
            }
        }

        //Moving a tile
        if($waterCanSlide[$tileID]) {
            foreach($waterMoves[$waterPosition] as $waterPositionAfterMoved => $direction) {
                if($waterPositionAfterMoved == $playerPosition) continue;

                //A tile & water can switch
                $newHash = $hash;

                //Set the tile ID where the water used to be
                $newHash &= ~(15 << ($waterPosition * 4));
                $newHash |= ((($hash >> ($waterPositionAfterMoved * 4)) & 15) << ($waterPosition * 4));

                //Set the tile ID as water on it's new position
                $newHash &= ~(15 << ($waterPositionAfterMoved * 4));
                $newHash |= ((($hash >> ($waterPosition * 4)) & 15) << ($waterPositionAfterMoved * 4));

                $newHash &= ~(15 << 40); //Erase current water position
                $newHash |= $waterPositionAfterMoved << 40; //Set new water position
 
                $queue[$turn + 1][] = [$newHash, $moves . 'T' . $direction];
            }
        }
    }

    unset($queue[$turn]);

    ++$turn;
}

$len = strlen($solution);

echo ($len / 2) . PHP_EOL;

for($i = 0; $i < $len; $i += 2) {
    echo $solution[$i] . " " . DIRECTIONS[$solution[$i + 1]] . PHP_EOL;
}

error_log(microtime(1) - $start);
