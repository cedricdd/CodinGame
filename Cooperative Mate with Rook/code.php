<?php

//Generate the minimum distance to the edge of the board from any positions
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

//Generate all the moves a king can do from any positions
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

//Generate all the moves a rook can do from any positions
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

//This is assuming that the rook only has to move to checkmate, there are no test/validator that requires the rook to move more than one
function generateWinPositions(int $rookPosition): array {
    $positions = [];

    [$xR, $yR] = [$rookPosition % 8, intdiv($rookPosition, 8)];

    //Wining with black king on the top row
    for($x = 0; $x < 8; ++$x) {
        if(abs($x - $xR) <= 1) continue;

        $positions[$x][2 * 8 + $x] = $xR; 
    }

    //Wining with black king on the bottom row
    for($x = 0; $x < 8; ++$x) {
        if(abs($x - $xR) <= 1) continue;

        $positions[7 * 8 + $x][5 * 8 + $x] = 7 * 8 + $xR;
    }

    //Wining with black king on the left col
    for($y = 0; $y < 8; ++$y) {
        if(abs($y - $yR) <= 1) continue;

        $positions[$y * 8][$y * 8 + 2] = $yR * 8;
    }

    //Wining with black king on the right col
    for($y = 0; $y < 8; ++$y) {
        if(abs($y - $yR) <= 1) continue;

        $positions[$y * 8 + 7][$y * 8 + 5] = $yR * 8 + 7;
    }

    return $positions;
}

$alphabet = range("a", "h");
$alphabetFlipped = array_flip($alphabet);

//Convert a board position into it's position into the array a8 = 0, b8 = 1, ..., h1 = 63
function boardToArray(string $position): int {
    global $alphabetFlipped;

    return (8 - intval($position[1])) * 8 + $alphabetFlipped[$position[0]];
}

//Convert an array position into it's position on the board 0 = a8, 1 = b8, ..., 63 = h1
function arrayToBoard(int $position): string {
    global $alphabet;

    $x = $position % 8;
    $y = intdiv($position, 8);

    return $alphabet[$x] . (8 - $y);
}

fscanf(STDIN, "%s %s %s %s", $movingPlayer, $whiteKing, $whiteRook, $blackKing);

$start = microtime(1);

$movingPlayer = $movingPlayer == "white" ? 1 : 0;
$whiteKing = boardToArray($whiteKing);
$whiteRook = boardToArray($whiteRook);
$blackKing = boardToArray($blackKing);

$distances = generateDistanceToEdge();

$movesKing = generateKingsMoves();

$movesRook = generateRookMoves();

$winPositions = generateWinPositions($whiteRook);

//Representation of the board
$board = str_repeat(" ", 64);
$board[$whiteRook] = "R";
$board[$whiteKing] = "K";
$board[$blackKing] = "k";

$history = [];

$toCheck = [[$board, $movingPlayer, $whiteKing, $whiteRook, $blackKing, []]];

while(count($toCheck)) {

    $newCheck = [];

    foreach($toCheck as [$board, $movingPlayer, $whiteKing, $whiteRook, $blackKing, $moves]) {

        if(isset($history[$movingPlayer][$board])) continue; //Configuration we have already checked
        else $history[$movingPlayer][$board] = 1;

        $countMoves = count($moves);

        $movesWhiteKing = $movesKing[$whiteKing];
        $movesWhiteRook = $movesRook[$whiteRook];
        $movesBlackKing = $movesKing[$blackKing];

        [$blackKingX, $blackKingY] = [$blackKing % 8, intdiv($blackKing, 8)];
        [$whiteKingX, $whiteKingY] = [$whiteKing % 8, intdiv($whiteKing, 8)];

        $distanceBetweenKings = abs($whiteKingX - $blackKingX) + abs($whiteKingY - $blackKingY);

        $nextMovingPlayer = ($movingPlayer ^ 1);

        //It's white turn to play
        if($movingPlayer == 1) {
            //Check if we are in a winningPostion
            if(isset($winPositions[$blackKing][$whiteKing])) {
                //Move the rook to checkmate
                $moves[] = [$whiteRook, $winPositions[$blackKing][$whiteKing]];

                echo implode(" ", array_map(function($move) {
                    return arrayToBoard($move[0]) . arrayToBoard($move[1]);
                }, $moves)) . PHP_EOL;

                break 2;
            }

            $board[$whiteKing] = " ";

            foreach($movesWhiteKing as $indexKing => $filler) {
                //White king can't move where black king can move
                if(isset($movesBlackKing[$indexKing]) || $indexKing == $whiteRook || $indexKing == $blackKing) continue;

                [$indexX, $indexY] = [$indexKing % 8, intdiv($indexKing, 8)];

                //If white king is on the border of the board or is not moving farther from the black king we consider it as a potential move
                if($distances[$whiteKing] == 0 || $distanceBetweenKings >= abs($indexX - $blackKingX) + abs($indexY - $blackKingY)) {
                    $board[$indexKing] = "K"; //Update the representation of the board
    
                    $moves[$countMoves] = [$whiteKing, $indexKing]; //The moves we are testing
    
                    $newCheck[] = [$board, $nextMovingPlayer, $indexKing, $whiteRook, $blackKing, $moves];
    
                    $board[$indexKing] = " "; //Update the representation of the board
                }
            }

        } else {
            $board[$blackKing] = " ";

            foreach($movesBlackKing as $indexKing => $filler) {
                //Black king can't move where white king or white rook can move
                if(isset($movesWhiteKing[$indexKing]) || $indexKing == $whiteKing || isset($movesWhiteRook[$indexKing]) || $indexKing == $whiteRook) continue;

                //Black king is only allowed to move toward the edge of the map or away from it if it's already on the edge
                if($distances[$blackKing] == 0 || $distances[$indexKing] < $distances[$blackKing]) {
                    $board[$indexKing] = "k"; //Update the representation of the board
    
                    $moves[$countMoves] = [$blackKing, $indexKing]; //The moves we are testing
    
                    $newCheck[] = [$board, $nextMovingPlayer, $whiteKing, $whiteRook, $indexKing, $moves];

                    $board[$indexKing] = " "; //Update the representation of the board
                } 
            }

        }
    }

    $toCheck = $newCheck;
}

error_log(microtime(1) - $start);
