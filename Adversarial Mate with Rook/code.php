<?php

function chessToGrid(string $position): array {
    return [ord($position[0]) - 97, 8 - intval($position[1])];
}

function gridToChess(int $x, int $y): string {
    return chr($x + 97) . (8 - $y);
}

$kingMoves = [];
$rookMoves = [];
$distances = [];

for($y = 0, $index = 0; $y < 8; ++$y) {
    for($x = 0; $x < 8; ++$x, ++$index) {
        //King Moves
        for($y2 = 0; $y2 < 8; ++$y2) {
            for($x2 = 0; $x2 < 8; ++$x2) {
                $distance = max(abs($x - $x2), abs($y - $y2));

                $distances[$y][$x][$y2][$x2] = $distance;

                if($distance == 1) $kingMoves[$y][$x][] = [$x2, $y2];
            }
        }

        //Rook Moves
        for($i = 1; $i < 8; ++$i) {
            //Left
            if($x - $i >= 0) $rookMoves[$index][$index - $i] = true;
            //Right
            if($x + $i < 8) $rookMoves[$index][$index + $i] = true;
            //Top
            if($y - $i >= 0) $rookMoves[$index][$index - (8 * $i)] = true;
            //Bottom
            if($y + $i < 8) $rookMoves[$index][$index + (8 * $i)] = true;
        }

        $coordinates[$index] = [$x, $y];
    }
}

// $whiteKing: Position of the white king, e.g. a2
// $whiteRook: Position of the white rook
// $blackKing: Position of the black king
fscanf(STDIN, "%s %s %s", $whiteKing, $whiteRook, $blackKing);

[$whiteKingX, $whiteKingY] = chessToGrid($whiteKing);
[$whiteRookX, $whiteRookY] = chessToGrid($whiteRook);
[$blackKingX, $blackKingY] = chessToGrid($blackKing);

error_log("WK: $whiteKing ($whiteKingX  - $whiteKingY)");
error_log("WR: $whiteRook ($whiteRookX  - $whiteRookY)");
error_log("BK: $blackKing ($blackKingX  - $blackKingY)");

$queue[1] = [[$whiteKingX, $whiteKingY, $whiteRookX, $whiteRookY, $blackKingX, $blackKingY, []]];
$turn = 1;
$solutions = [];


while(!$solutions) {
    foreach($queue[$turn] as [$whiteKingX, $whiteKingY, $whiteRookX, $whiteRookY, $blackKingX, $blackKingY, $moves]) {

        error_log("WK " . gridToChess($whiteKingX, $whiteKingY) . " WK " . gridToChess($whiteRookX, $whiteRookY) . " BK " . gridToChess($blackKingX, $blackKingY));

        //It's black turn
        if($turn % 2 == 0) {
            $checkmate = true;

            //We try every possible moves
            foreach($kingMoves[$blackKingY][$blackKingX] as [$moveX, $moveY]) {
                if($distances[$moveY][$moveX][$whiteKingY][$whiteKingX] == 1) continue; //We don't want to be checkmated by the other king

                //On the same col as the rook
                if($moveX == $whiteRookX) {
                    //Checking if white king is preventing the rook from taking black king
                    if($whiteKingX != $moveX || ($moveY - $whiteKingY) * ($whiteRookY - $whiteKingY) > 0) continue;
                } 
                //On the same row as the rook
                if($moveY == $whiteRookY) {
                    //Checking if white king is preventing the rook from taking black king
                    if($whiteKingY != $moveY || ($moveX - $whiteKingX) * ($whiteRookX - $whiteKingX) > 0) continue;
                }

                error_log("black king at $blackKing can move to $moveX $moveY - " . gridToChess($moveX, $moveY));

                $moves[$turn] = gridToChess($blackKingX, $blackKingY) . gridToChess($moveX, $moveY);

                $queue[$turn + 1][] = [$whiteKingX, $whiteKingY, $whiteRookX, $whiteRookY, $moveX, $moveY, $moves];

                $checkmate = false;
            }

            if($checkmate) {
                $solutions[] = $moves;
            }
        }
        //It's white turn
        else {
            $distance = $distances[$whiteKingY][$whiteKingX][$blackKingY][$blackKingX];
            error_log("WK is at $distance from BK");

            foreach($kingMoves[$whiteKingY][$whiteKingX] as [$moveX, $moveY]) {
                $distanceAfterMove = $distances[$moveY][$moveX][$blackKingY][$blackKingX];

                if($distanceAfterMove == 1) continue; //We are not suicidal
                if($distanceAfterMove > $distance) continue; //We never move away from the other king
                if($distanceAfterMove == $distance && ($whiteKingX == $blackKingX || $whiteKingY == $blackKingY)) continue; //We arealdy are on the same row or col, best place for blocking the most positions

                error_log("WK can move to $moveX $moveY - New Distance $distanceAfterMove");
            }

            //Can we move the rook closer
            $goal = "";
            $distanceGoal = 10;

            foreach(['TOP' => $blackKingY, 'LEFT' => $blackKingX, 'RIGHT' => 7 - $blackKingX, 'BOTTOM' => 7 - $blackKingY] as $border => $dist) {
                if($dist < $distanceGoal) {
                    $distanceGoal = $dist;
                    $goal = $border;
                }
            }

            if($goal == 'TOP') {
                //
            } elseif($goal == 'LEFT') {
                //
            } elseif($goal == 'RIGHT') {

            } elseif($goal == 'BOTTOM') {
                error_log("trying to pin to bottom border");

                for($i = 0; $i < 2; ++$i) {
                    if($whiteRookY < $blackKingY - $i) {
                        [$moveX, $moveY] = [$whiteRookX, $blackKingY - $i];

                        $distanceAfterMove = $distances[$moveY][$moveX][$blackKingY][$blackKingX];

                        if($distanceAfterMove != 1) {
                            $moves[$turn] = gridToChess($whiteRookX, $whiteRookY) . gridToChess($moveX, $moveY);

                            $queue[$turn + 1][] = [$whiteKingX, $whiteKingY, $moveX, $moveY, $blackKingX, $blackKingY, $moves];

                            error_log("moving rook to $moveX $moveY - " . gridToChess($moveX, $moveY));
                        }
                    }
                }
            }
        }
    }

    unset($queue[$turn]);

    ++$turn;

    if($turn == 3) break;
}

error_log(var_export($solutions, 1));
die();

// game loop
while (TRUE)
{
    // $opponentMove: A move made by the opponent, e.g. a2b1
    fscanf(STDIN, "%s", $opponentMove);

    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug: error_log(var_export($var, true)); (equivalent to var_dump)
}
