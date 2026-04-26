<?php

const MAX_SIZE_SOLUTION = 15;

function chessToGrid(string $position): array {
    return [ord($position[0]) - 97, 8 - intval($position[1])];
}

function gridToChess(int $x, int $y): string {
    return chr($x + 97) . (8 - $y);
}

function isBetween(int $a, int $b, int $c): bool {
    return ($a - $c) * ($b - $c) < 0;
}

$kingMoves = [];
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
    }
}

// $whiteKing: Position of the white king, e.g. a2
// $whiteRook: Position of the white rook
// $blackKing: Position of the black king
fscanf(STDIN, "%s %s %s", $whiteKing, $whiteRook, $blackKing);

$start = microtime(1);

[$whiteKingX, $whiteKingY] = chessToGrid($whiteKing);
[$whiteRookX, $whiteRookY] = chessToGrid($whiteRook);
[$blackKingX, $blackKingY] = chessToGrid($blackKing);

function solve(int $whiteKingX, int $whiteKingY, int $whiteRookX, int $whiteRookY, int $blackKingX, int $blackKingY, int $turn, array $moves) :?array {
    global $distances, $kingMoves;
    static $maxLen = MAX_SIZE_SOLUTION;

    if($turn >= $maxLen) return null;

    //It's black turn
    if($turn % 2 == 0) {
        $results = [0, []];
        $canMove = false;

        //We try every possible moves for the black king
        foreach($kingMoves[$blackKingY][$blackKingX] as [$moveX, $moveY]) {
            if($distances[$moveY][$moveX][$whiteKingY][$whiteKingX] == 1) continue; //We don't want to be checkmated by the other king directly

            //On the same col as the rook
            if($moveX == $whiteRookX) {
                //Checking if white king is preventing the rook from taking black king
                if($whiteKingX != $moveX || isBetween($moveY , $whiteRookY, $whiteKingY) === false) continue;
            } 
            //On the same row as the rook
            if($moveY == $whiteRookY) {
                //Checking if white king is preventing the rook from taking black king
                if($whiteKingY != $moveY || isBetween($moveX , $whiteRookX, $whiteKingX) === false) continue;
            }

            $canMove = true;

            $moves[$turn] = gridToChess($blackKingX, $blackKingY) . gridToChess($moveX, $moveY);

            $result = solve($whiteKingX, $whiteKingY, $whiteRookX, $whiteRookY, $moveX, $moveY, $turn + 1, $moves);

            if($result === null) return null;
            //We need to end up with a checkmate no matter what the black king does
            else {
                $results[0] = max($results[0], $result[0]);
                $results[1] = array_merge($results[1], $result[1]);
            }
        }

        //Black king can't move anywhere
        if($canMove === false) {
            //The black king needs to be in a check, he can only be checked by the rook
            if(($whiteRookX == $blackKingX && ($whiteRookX != $whiteKingX || isBetween($whiteRookY, $blackKingY, $whiteKingY) === false)) || ($whiteRookY == $blackKingY && ($whiteRookY != $whiteKingY || isBetween($whiteRookX, $blackKingX, $whiteKingX) === false))) {
                return [$turn - 1, [$moves]];
            }

            //It's a stalemate 
            else return null;
        }
        //Black king can still move
        else return $results;
    }
    //It's white turn
    else {
        $distanceKing = $distances[$whiteKingY][$whiteKingX][$blackKingY][$blackKingX];
        $distanceRook = $distances[$whiteRookY][$whiteRookX][$blackKingY][$blackKingX];
        $bestSolution = [MAX_SIZE_SOLUTION, []];

        //The black king can take the rook, we can't win without the rook, we have to save it
        if($distanceRook == 1) {
            //We try to 'guard' the rook with our king
            foreach($kingMoves[$whiteKingY][$whiteKingX] as [$moveX, $moveY]) {
                if($distances[$moveY][$moveX][$whiteRookY][$whiteRookX] == 1 && $distances[$moveY][$moveX][$blackKingY][$blackKingX] > 1) {
                    $moves[$turn] = gridToChess($whiteKingX, $whiteKingY) . gridToChess($moveX, $moveY);

                    $result = solve($moveX, $moveY, $whiteRookX, $whiteRookY, $blackKingX, $blackKingY, $turn + 1, $moves);

                    if($result !== null && $result[0] < $bestSolution[0]) {
                        $bestSolution = $result;

                        //We update the current maxLen to prune everything taking longer
                        if($turn == 1) $maxLen = $result[0];
                    }
                }
            }

            //Move the rook away to save it
            $evadeMoves = [
                [7, $whiteRookY, 'Y', 'X'], //Moving to the right
                [0, $whiteRookY, 'Y', 'X'], //Moving to the left
                [$whiteRookX, 0, 'X', 'Y'], //Moving to the top
                [$whiteRookX, 7, 'X', 'Y'], //Moving to the bottom
            ];
            for($i = 0; $i < 4; ++$i) {
                [$moveX, $moveY, $c1, $c2] = $evadeMoves[$i];

                //Make sure the rook ends up in a safe place and there's no piece preventing the move
                if($distances[$moveY][$moveX][$blackKingY][$blackKingX] > 1 && (${"whiteRook" . $c1} != ${"whiteKing" . $c1} || isBetween(${"whiteRook" . $c2}, ${"move" . $c2}, ${"whiteKing" . $c2}) === false) && (${"whiteRook" . $c1} != ${"blackKing" . $c1} || isBetween(${"whiteRook" . $c2}, ${"move" . $c2}, ${"blackKing" . $c2}) === false)) {
                    $moves[$turn] = gridToChess($whiteRookX, $whiteRookY) . gridToChess($moveX, $moveY);

                    $result = solve($whiteKingX, $whiteKingY, $moveX, $moveY, $blackKingX, $blackKingY, $turn + 1, $moves);

                    if($result !== null && $result[0] < $bestSolution[0]) {
                        $bestSolution = $result;

                        //We update the current maxLen to prune everything taking longer
                        if($turn == 1) $maxLen = $result[0];
                    }

                    if($i == 0 || $i == 2) ++$i; //We only need one for horizontal & vertical
                }
            }
        } else {
            foreach($kingMoves[$whiteKingY][$whiteKingX] as [$moveX, $moveY]) {
                if($moveX == $whiteRookX && $moveY == $whiteRookY) continue; //Our rook is already there

                $distanceAfterMove = $distances[$moveY][$moveX][$blackKingY][$blackKingX];

                if($distanceAfterMove == 1) continue; //We are not suicidal
                if($distanceAfterMove > $distanceKing) continue; //We never move away from the other king
                if($distanceAfterMove == $distanceKing && ($whiteKingX == $blackKingX || $whiteKingY == $blackKingY)) continue; //We arealdy are on the same row or col, best place for blocking the most positions

                $moves[$turn] = gridToChess($whiteKingX, $whiteKingY) . gridToChess($moveX, $moveY);

                $result = solve($moveX, $moveY, $whiteRookX, $whiteRookY, $blackKingX, $blackKingY, $turn + 1, $moves);

                if($result !== null && $result[0] < $bestSolution[0]) {
                    $bestSolution = $result;

                    //We update the current maxLen to prune everything taking longer
                    if($turn == 1) $maxLen = $result[0];
                }
            }

            for($i = -1; $i <= 1; ++$i) {
                /*Move rook vertically*/
                $moveX = $whiteRookX;
                $moveY = $blackKingY + $i;
  
                //The move is valid (still on the grid & actually moving)
                if($whiteRookX != $blackKingX && $moveY != $whiteRookY && $moveY >= 0 && $moveY < 8) {

                    //Make sure our king isn't in the way
                    if($whiteKingX != $whiteRookX || isBetween($whiteRookY, $moveY, $whiteKingY) === false) {

                        //If after the move our king is bewteen the rook and the black king then the move is useless
                        if($whiteKingY != $moveY || isBetween($blackKingX, $moveX, $whiteKingX) === false) {
   
                            //The rook can't be taken after the move or it's guarded by our king
                            if($distances[$moveY][$moveX][$blackKingY][$blackKingX] > 1 || $distances[$moveY][$moveX][$whiteKingY][$whiteKingX] == 1) {
                                $moves[$turn] = gridToChess($whiteRookX, $whiteRookY) . gridToChess($moveX, $moveY);

                                $result = solve($whiteKingX, $whiteKingY, $moveX, $moveY, $blackKingX, $blackKingY, $turn + 1, $moves);

                                if($result !== null && $result[0] < $bestSolution[0]) {
                                    $bestSolution = $result;

                                    //We update the current maxLen to prune everything taking longer
                                    if($turn == 1) $maxLen = $result[0];
                                }
                            }
                        }
                    }
                }

                /*Move rook horizontally */
                $moveX = $blackKingX + $i;
                $moveY = $whiteRookY;

                //The move is valid (still on the grid & actually moving)
                if($whiteRookY != $blackKingY && $moveX != $whiteRookX && $moveX >= 0 && $moveX < 8) {

                    //Make sure our king isn't in the way
                     if($whiteKingY != $whiteRookY || isBetween($whiteRookX, $moveX, $whiteKingX) === false) {
                        
                        //If after the move our king is bewteen the rook and the black king then the move is useless
                        if($whiteKingX != $moveX || isBetween($blackKingY, $moveY, $whiteKingY) === false) {

                            //The rook can't be taken after the move or it's guarded by our king
                            if($distances[$moveY][$moveX][$blackKingY][$blackKingX] > 1 || $distances[$moveY][$moveX][$whiteKingY][$whiteKingX] == 1) {
                                $moves[$turn] = gridToChess($whiteRookX, $whiteRookY) . gridToChess($moveX, $moveY);

                                $result = solve($whiteKingX, $whiteKingY, $moveX, $moveY, $blackKingX, $blackKingY, $turn + 1, $moves);

                                if($result !== null && $result[0] < $bestSolution[0]) {
                                    $bestSolution = $result;

                                    //We update the current maxLen to prune everything taking longer
                                    if($turn == 1) $maxLen = $result[0];
                                }
                            }
                        }
                    }
                }
            }
        }

        if($bestSolution[0] < MAX_SIZE_SOLUTION) return $bestSolution;
        else return null;
    }
}

[$size, $solutions] = solve($whiteKingX, $whiteKingY, $whiteRookX, $whiteRookY, $blackKingX, $blackKingY, 1, []);

error_log(microtime(1) - $start);

$turn = 1;

// game loop
while (TRUE) {
    echo $solutions[array_key_first($solutions)][$turn] . PHP_EOL;

    // $opponentMove: A move made by the opponent, e.g. a2b1
    fscanf(STDIN, "%s", $opponentMove);

    error_log("Opp Move:" . $opponentMove);

    //Remove all the solutions that don't use the opp move
    foreach($solutions as $index => $solution) {
        if($solution[$turn + 1] != $opponentMove) unset($solutions[$index]);
    }

    $turn += 2;
}
