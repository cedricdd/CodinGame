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

error_log("WK: $whiteKing ($whiteKingX  - $whiteKingY)");
error_log("WR: $whiteRook ($whiteRookX  - $whiteRookY)");
error_log("BK: $blackKing ($blackKingX  - $blackKingY)");

$solutionsMaxLen = MAX_SIZE_SOLUTION;
$solutions = [];

function solve(int $whiteKingX, int $whiteKingY, int $whiteRookX, int $whiteRookY, int $blackKingX, int $blackKingY, int $turn, array $moves) :?array {
    global $solutions, $solutionsMaxLen, $distances, $kingMoves, $start;
    static $history = [];

    $key = $whiteKingX | ($whiteKingY << 3) | ($whiteRookX << 6) | ($whiteRookY << 9) | ($blackKingX << 12) | ($blackKingY << 15);

    if(isset($history[$key]) && $history[$key] <= $turn) return null;
    else $history[$key] = $turn;

    $wk = gridToChess($whiteKingX, $whiteKingY);
    $wr = gridToChess($whiteRookX, $whiteRookY);
    $bk = gridToChess($blackKingX, $blackKingY);

    if($wk == "f1" && $wr == "e3" && $bk == "h21") $debug = true;
    else $debug = false;

    if($turn >= $solutionsMaxLen) return null;

    if($debug) error_log("Turn $turn -- WK: $wk WR: $wr BK: $bk");

    //It's black turn
    if($turn % 2 == 0) {
        $results = [0, []];
        $canMove = false;

        //We try every possible moves
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

            if($debug) error_log("black king at " . gridToChess($blackKingX, $blackKingY) . " can move to $moveX $moveY - " . gridToChess($moveX, $moveY));

            $moves[$turn] = gridToChess($blackKingX, $blackKingY) . gridToChess($moveX, $moveY);

            $result = solve($whiteKingX, $whiteKingY, $whiteRookX, $whiteRookY, $moveX, $moveY, $turn + 1, $moves);

            if($result === null) return null;
            else {
                $results[0] = max($results[0], $result[0]);
                $results[1] = array_merge($results[1], $result[1]);
            }
        }

        if($canMove === false) {
            //The black king needs to be in a check, he can only be checked by the rook
            if(($whiteRookX == $blackKingX && isBetween($whiteRookX, $blackKingX, $whiteKingX) === false) || ($whiteRookY == $blackKingY && isBetween($whiteRookY, $blackKingY, $whiteKingY) === false)) return [$turn - 1, [$moves]];

            //It's a stalemate 
            else return null;
        }
        else return $results;
    }
    //It's white turn
    else {
        $distanceKing = $distances[$whiteKingY][$whiteKingX][$blackKingY][$blackKingX];
        $distanceRook = $distances[$whiteRookY][$whiteRookX][$blackKingY][$blackKingX];
        $bestSolution = [MAX_SIZE_SOLUTION, []];

        //The black king can take the rook, we can't win without the rook, we have to save it
        if($distanceRook == 1 && $distances[$whiteKingY][$whiteKingX][$whiteRookY][$whiteRookX] != 1) {
            //We try to 'guard' the rook with our king
            foreach($kingMoves[$whiteKingY][$whiteKingX] as [$moveX, $moveY]) {
                if($distances[$moveY][$moveX][$whiteRookY][$whiteRookX] == 1) {
                    if($debug) error_log("we can move our king at " . gridToChess($moveX, $moveY) . " to save the rook"); 

                    $moves[$turn] = gridToChess($whiteKingX, $whiteKingY) . gridToChess($moveX, $moveY);

                    $result = solve($moveX, $moveY, $whiteRookX, $whiteRookY, $blackKingX, $blackKingY, $turn + 1, $moves);

                    if($result !== null) {
                        if($turn == 1) {
                            [$solutionsMaxLen, $solutions] = $result;

                            error_log("1 new best $solutionsMaxLen");
                            // error_log(var_export($moves, 1));
                            error_log(microtime(1) - $start);
                        }
                        elseif($result[0] < $bestSolution[0]) $bestSolution = $result;
                    }
                }
            }

            //Move the rook away to the left
            for($i = 1; $i < 8; ++$i) {
                $moveX = $whiteRookX - $i;
                $moveY = $whiteRookY;

                if($moveX < 0) break;

                if(($whiteKingX == $moveX && $whiteKingY == $moveY) || ($blackKingX == $moveX && $blackKingY == $moveY)) continue;

                if($distances[$moveY][$moveX][$blackKingY][$blackKingX] > 1) {
                    if($debug) error_log("moving rook to " . gridToChess($moveX, $moveY) . " to save itself"); 

                    $moves[$turn] = gridToChess($whiteKingX, $whiteKingY) . gridToChess($moveX, $moveY);

                    $result = solve($whiteKingX, $whiteKingY, $moveX, $moveY, $blackKingX, $blackKingY, $turn + 1, $moves);

                    if($result !== null) {
                        if($turn == 1) {
                            [$solutionsMaxLen, $solutions] = $result;

                            error_log("2 new best $solutionsMaxLen");
                            // error_log(var_export($moves, 1));
                            error_log(microtime(1) - $start);
                        }
                        elseif($result[0] < $bestSolution[0]) $bestSolution = $result;
                    }

                    break;
                }
            }
        } else {
            // error_log("WK is at $distance from BK");

            foreach($kingMoves[$whiteKingY][$whiteKingX] as [$moveX, $moveY]) {
                //Our rook is already there
                if($moveX == $whiteRookX && $moveY == $whiteRookY) continue;

                $distanceAfterMove = $distances[$moveY][$moveX][$blackKingY][$blackKingX];

                if($distanceAfterMove == 1) continue; //We are not suicidal
                if($distanceAfterMove > $distanceKing) continue; //We never move away from the other king
                if($distanceAfterMove == $distanceKing && ($whiteKingX == $blackKingX || $whiteKingY == $blackKingY)) continue; //We arealdy are on the same row or col, best place for blocking the most positions

                if($debug) error_log("WK can move to $moveX $moveY " . gridToChess($moveX, $moveY) . " - New Distance $distanceAfterMove");
                $moves[$turn] = gridToChess($whiteKingX, $whiteKingY) . gridToChess($moveX, $moveY);

                $result = solve($moveX, $moveY, $whiteRookX, $whiteRookY, $blackKingX, $blackKingY, $turn + 1, $moves);

                if($result !== null) {
                    if($turn == 1) {
                        [$solutionsMaxLen, $solutions] = $result;

                        error_log("3 new best $solutionsMaxLen");
                        // error_log(var_export($moves, 1));
                        error_log(microtime(1) - $start);
                    }
                    elseif($result[0] < $bestSolution[0]) $bestSolution = $result;
                }
            }

            for($i = -2; $i <= 2; ++$i) {
                /*Move rook vertically*/
                $moveX = $whiteRookX;
                $moveY = $blackKingY + $i;
  
                //The move is valid (still on the grid & actually moving)
                if($whiteRookX != $blackKingX && $moveY >= 0 && $moveY < 8) {

                    //Make sure our king isn't in the way
                    if($whiteKingX != $whiteRookX || isBetween($whiteRookY, $moveY, $whiteKingY) === false) {

                        //If after the move our king is bewteen the rook and the black king then the move is useless
                        if($whiteKingY != $moveY || isBetween($blackKingX, $moveX, $whiteKingX) === false) {
   
                            //The rook can't be taken after the move or it's guarded by our king
                            if($distances[$moveY][$moveX][$blackKingY][$blackKingX] > 1 || $distances[$moveY][$moveX][$whiteKingY][$whiteKingX] == 1) {
                                if($debug) error_log("1 rook at " . gridToChess($whiteRookX, $whiteRookY) . " can move to $moveX $moveY - " . gridToChess($moveX, $moveY));

                                $moves[$turn] = gridToChess($whiteRookX, $whiteRookY) . gridToChess($moveX, $moveY);

                                $result = solve($whiteKingX, $whiteKingY, $moveX, $moveY, $blackKingX, $blackKingY, $turn + 1, $moves);

                                if($result !== null) {
                                    if($turn == 1) {
                                        [$solutionsMaxLen, $solutions] = $result;

                                        error_log("4 new best $solutionsMaxLen");
                                        // error_log(var_export($moves, 1));
                                        error_log(microtime(1) - $start);
                                    }
                                    elseif($result[0] < $bestSolution[0]) $bestSolution = $result;
                                }
                            }
                        }
                    }
                }

                /*Move rook horizontally */
                $moveX = $blackKingX + $i;
                $moveY = $whiteRookY;

                // if($debug) error_log("testing moving rook at $moveX $moveY " . gridToChess($moveX, $moveY));

                //The move is valid (still on the grid & actually moving)
                if($whiteRookY != $blackKingY && $moveX >= 0 && $moveX < 8) {

                    //Make sure our king isn't in the way
                     if($whiteKingY != $whiteRookY || isBetween($whiteRookX, $moveX, $whiteKingX) === false) {
                        
                        //If after the move our king is bewteen the rook and the black king then the move is useless
                        if($whiteKingX != $moveX || isBetween($blackKingY, $moveY, $whiteKingY) === false) {

                            //The rook can't be taken after the move or it's guarded by our king
                            if($distances[$moveY][$moveX][$blackKingY][$blackKingX] > 1 || $distances[$moveY][$moveX][$whiteKingY][$whiteKingX] == 1) {
                                if($debug) error_log("2 rook at " . gridToChess($whiteRookX, $whiteRookY) . " can move to $moveX $moveY - " . gridToChess($moveX, $moveY));

                                $moves[$turn] = gridToChess($whiteRookX, $whiteRookY) . gridToChess($moveX, $moveY);

                                $result = solve($whiteKingX, $whiteKingY, $moveX, $moveY, $blackKingX, $blackKingY, $turn + 1, $moves);

                                if($result !== null) {
                                    if($turn == 1) {
                                        [$solutionsMaxLen, $solutions] = $result;

                                        error_log("5 new best $solutionsMaxLen");
                                        error_log(var_export($result, 1));
                                        error_log(microtime(1) - $start);
                                    }
                                    elseif($result[0] < $bestSolution[0]) $bestSolution = $result;
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

solve($whiteKingX, $whiteKingY, $whiteRookX, $whiteRookY, $blackKingX, $blackKingY, 1, []);

error_log(var_export($solutions, 1));
error_log(microtime(1) - $start);

$turn = 1;

// game loop
while (TRUE)
{
    echo $solutions[array_key_first($solutions)][$turn] . PHP_EOL;

    // $opponentMove: A move made by the opponent, e.g. a2b1
    fscanf(STDIN, "%s", $opponentMove);

    error_log("Opp Move:" . $opponentMove);

    foreach($solutions as $index => $solution) {
        if($solution[$turn + 1] != $opponentMove) unset($solutions[$index]);
    }

    $turn += 2;
}
