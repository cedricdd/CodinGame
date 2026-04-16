<?php

function chessPositionToIndex(string $position): int {
    return (8 - intval($position[1])) * 8 + (ord($position[0]) - 97);
}

function indexToChessPosition(int $index): string {
    return chr($index % 8 + 97) . (8 - intdiv($index, 8));
}

$kingMoves = [];
$rookMoves = [];

for($y = 0, $index = 0; $y < 8; ++$y) {
    for($x = 0; $x < 8; ++$x, ++$index) {
        //King Moves
        for($y2 = max(0, $y - 1); $y2 <= min(7, $y + 1); ++$y2) {
            for($x2 = max(0, $x - 1); $x2 <= min(7, $x + 1); ++$x2) {
                if($x2 == $x && $y2 == $y) continue;

                $kingMoves[$index][$y2 * 8 + $x2] = true;
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

$whiteKing = chessPositionToIndex($whiteKing);
$whiteRook = chessPositionToIndex($whiteRook);
$blackKing = chessPositionToIndex($blackKing);

error_log("WK: $whiteKing (" . ($whiteKing % 8) . " - " . intdiv($whiteKing, 8) . ")");
error_log("WK: $whiteRook (" . ($whiteRook % 8) . " - " . intdiv($whiteRook, 8) . ")");
error_log("WK: $blackKing (" . ($blackKing % 8) . " - " . intdiv($blackKing, 8) . ")");

$queue[1] = [[$whiteKing, $whiteRook, $blackKing, []]];
$turn = 1;
$solutions = [];

while(!$solutions) {
    foreach($queue[$turn] as [$whiteKing, $whiteRook, $blackKing, $moves]) {
        //It's black turn
        if($turn % 2 == 0) {
            $checkmate = true;

            //We try every possible moves
            foreach($kingMoves[$blackKing] as $newPosition => $_) {
                if(isset($kingMoves[$whiteKing][$newPosition]) || isset($rookMoves[$whiteRook][$newPosition])) continue;

                error_log("black king at $blackKing can move to $newPosition");

                $moves[$turn] = indexToChessPosition($blackKing) . indexToChessPosition($newPosition);

                $queue[$turn + 1][] = [$whiteKing, $whiteRook, $newPosition, $moves];

                $checkmate = false;
            }

            if($checkmate) {
                $solutions[] = $moves;
            }
        }
        //It's white turn
        else {
            [$blackKingX, $blackKingY] = $coordinates[$blackKing];
            [$whiteKingX, $whiteKingY] = $coordinates[$whiteKing];
            [$whiteRookX, $whiteRookY] = $coordinates[$whiteRook];

            //Black king can't go any lower, it's checkmate
            if($blackKingY == 7 && $whiteKingY == 5 && $whiteKingX == $blackKingX) {
                $newPosition = 7 * 8 + $whiteRookX;
                $moves[$turn] = indexToChessPosition($whiteRook) . indexToChessPosition($newPosition);

                $queue[$turn + 1][] = [$whiteKing, $newPosition, $blackKing, $moves];
            }
        }
    }

    unset($queue[$turn]);

    ++$turn;

    if($turn == 10) break;
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
