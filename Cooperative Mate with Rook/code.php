<?php

function generateKingsMoves(): array {
    $moves = [];

    for($y = 0; $y < 8; ++$y) {
        for($x = 0; $x < 8; ++$x) {
            $index = $y * 8 + $x;

            for($y2 = max(0, $y - 1); $y2 < min(8, $y + 2); ++$y2) {
                for($x2 = max(0, $x - 1); $x2 < min(8, $x + 2); ++$x2) {
                    if($x == $x2 && $y == $y2) continue;

                    $moves[$index][$y2 * 8 + $x2] = 1;
                }
            }
        }
    }

    return $moves;
}

function generateDistanceToEdge(): array {
    $distances = [];

    for($y = 0; $y < 8; ++$y) {
        for($x = 0; $x < 8; ++$x) {
            $index = $y * 8 + $x;

            $distances[$index] = min($x, $y, 7 - $x, 7 - $y);
        }
    }

    return $distances;
}

function generateRookMoves(): array {
    $moves = [];

    for($y = 0; $y < 8; ++$y) {
        for($x = 0; $x < 8; ++$x) {
            $index = $y * 8 + $x;

            $x2 = $x3 = $x;

            while(--$x2 >= 0) $moves[$index][$y * 8 + $x2] = 1;
            while(++$x3 <= 7) $moves[$index][$y * 8 + $x3] = 1;

            $y2 = $y3 = $y;

            while(--$y2 >= 0) $moves[$index][$y2 * 8 + $x] = 1;
            while(++$y3 <= 7) $moves[$index][$y3 * 8 + $x] = 1;
        }
    }

    return $moves;
}

function generateWinPositions(int $rookPosition): array {
    $positions = [];

    [$xR, $yR] = [$rookPosition % 8, intdiv($rookPosition, 8)];

    //Wining with black king on the top row
    if($yR != 0) {
        for($x = 0; $x < 8; ++$x) {
            if(abs($x - $xR) <= 1) continue;
    
            $positions[$x][2 * 8 + $x] = $xR;
        }
    }

    //Wining with black king on the bottom row
    if($yR != 7) {
        for($x = 0; $x < 8; ++$x) {
            if(abs($x - $xR) <= 1) continue;
    
            $positions[7 * 8 + $x][5 * 8 + $x] = 7 * 8 + $xR;
        }
    }

    //Wining with black king on the left col
    if($xR != 0) {
        for($y = 0; $y < 8; ++$y) {
            if(abs($y - $yR) <= 1) continue;
    
            $positions[$y * 8][$y * 8 + 2] = $yR * 8;
        }
    }

    //Wining with black king on the right col
    if($xR != 7) {
        for($y = 0; $y < 8; ++$y) {
            if(abs($y - $yR) <= 1) continue;
    
            $positions[$y * 8 + 7][$y * 8 + 5] = $yR * 8 + 7;
        }
    }

    return $positions;
}

$alphabet = range("a", "h");
$alphabetFlipped = array_flip($alphabet);

function boardToArray(string $position): int {
    global $alphabetFlipped;

    return (8 - intval($position[1])) * 8 + $alphabetFlipped[$position[0]];
}

function arrayToBoard(int $position): string {
    global $alphabet;

    $x = $position % 8;
    $y = intdiv($position, 8);

    return $alphabet[$x] . (8 - $y);
}

// $movingPlayer: Either black or white
// $whiteKing: Position of the white king, e.g. a2
// $whiteRook: Position of the white rook
// $blackKing: Position of the black king
fscanf(STDIN, "%s %s %s %s", $movingPlayer, $whiteKing, $whiteRook, $blackKing);

$start = microtime(1);

$movingPlayer = $movingPlayer == "white" ? 1 : 0;
$whiteKing = boardToArray($whiteKing);
$whiteRook = boardToArray($whiteRook);
$blackKing = boardToArray($blackKing);

error_log(var_export("Next player $movingPlayer", true));
error_log(var_export("White King $whiteKing " . arrayToBoard($whiteKing), true));
error_log(var_export("White Rook $whiteRook " . arrayToBoard($whiteRook), true));
error_log(var_export("Black King $blackKing " . arrayToBoard($blackKing), true));

$distances = generateDistanceToEdge();

//error_log(var_export($distances, true));

$movesKing = generateKingsMoves();

//error_log(var_export($movesKing, true));

$movesRook = generateRookMoves();

//error_log(var_export($movesRook, true));

$winPositions = generateWinPositions($whiteRook);

//error_log(var_export($winPositions, true));

$map = str_repeat(" ", 64);
$map[$whiteRook] = "R";
$map[$whiteKing] = "K";
$map[$blackKing] = "k";

$debug = true;

$history = [];

$toCheck = [[$map, $movingPlayer, $whiteKing, $whiteRook, $blackKing, []]];

$turn = 0;

while(count($toCheck)) {

    $newCheck = [];
    error_log("Turn " . ++$turn);

    foreach($toCheck as [$map, $movingPlayer, $whiteKing, $whiteRook, $blackKing, $moves]) {

        $history[$movingPlayer][$map] = 1;

        $countMoves = count($moves);

        $distanceBlackKing = $distances[$blackKing];

        $movesWhiteKing = $movesKing[$whiteKing];
        $movesWhiteRook = $movesRook[$whiteRook];
        $movesBlackKing = $movesKing[$blackKing];

        [$blackKingX, $blackKingY] = [$blackKing % 8, intdiv($blackKing, 8)];
        [$whiteKingX, $whiteKingY] = [$whiteKing % 8, intdiv($whiteKing, 8)];

        $test = abs($whiteKingX - $blackKingX) + abs($whiteKingY - $blackKingY);

        $nextMovingPlayer = ($movingPlayer ^ 1);

        if($debug) error_log("WK " . arrayToBoard($whiteKing) . " WR " . arrayToBoard($whiteRook) . " BK " . arrayToBoard($blackKing));

        if($movingPlayer == 1) {
            //Check if we are in a winningPostion
            if(isset($winPositions[$blackKing][$whiteKing])) {
                error_log("we are in a winnin position!");

                $moves[] = [$whiteRook, $winPositions[$blackKing][$whiteKing]];

                error_log(var_export($moves, true));

                echo implode(" ", array_map(function($move) {
                    return arrayToBoard($move[0]) . arrayToBoard($move[1]);
                }, $moves)) . PHP_EOL;

                break 2;
            }

            $map[$whiteKing] = " ";

            foreach($movesWhiteKing as $indexKing => $filler) {
                if(isset($movesBlackKing[$indexKing]) || $indexKing == $whiteRook || $indexKing == $blackKing) {
                    if($debug) error_log("white king can't move to $indexKing " . arrayToBoard($indexKing));
                    continue;
                } 

                [$indexX, $indexY] = [$indexKing % 8, intdiv($indexKing, 8)];

                if(1==1 || $test > abs($indexX - $blackKingX) + abs($indexY - $blackKingY)) {
                    $map2 = $map;
                    $map2[$indexKing] = "K";
    
                    if(isset($history[$nextMovingPlayer][$map2])) {
                        if($debug) error_log("$nextMovingPlayer $map2 already checked");
                        continue;
                    }
    
                    $moves[$countMoves] = [$whiteKing, $indexKing];
    
                    $newCheck[] = [$map2, $nextMovingPlayer, $indexKing, $whiteRook, $blackKing, $moves];
    
                    if($debug) error_log("white king can move from " . arrayToBoard($whiteKing) . " to " . arrayToBoard($indexKing));
                }
            }

        } else {
            $map[$blackKing] = " ";

            //Black king is only allowed to move toward the edge of the map
            foreach($movesBlackKing as $indexKing => $filler) {
                if(isset($movesWhiteKing[$indexKing]) || $indexKing == $whiteKing || isset($movesWhiteRook[$indexKing]) || $indexKing == $whiteRook) {
                    if($debug) error_log("black king can't move to $indexKing " . arrayToBoard($indexKing));
                    continue;
                }

                if($distances[$indexKing] <= $distanceBlackKing) {
                    if($debug) error_log("black king can move to $indexKing " . arrayToBoard($indexKing));
                    
                    $map2 = $map;
                    $map2[$indexKing] = "k";
    
                    if(isset($history[$nextMovingPlayer][$map2])) {
                        if($debug) error_log("$nextMovingPlayer $map2 already checked");
                        continue;
                    }
    
                    $moves[$countMoves] = [$blackKing, $indexKing];
    
                    $newCheck[] = [$map2, $nextMovingPlayer, $whiteKing, $whiteRook, $indexKing, $moves];
                } 
            }

        }
    }

    $toCheck = $newCheck;

    if($turn > 1) break;
}

error_log(microtime(1) - $start);
