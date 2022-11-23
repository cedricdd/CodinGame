<?php

//Return the position of a piece in array format with top left beign 0;0
function boardToArrayPosition(string $position): array {
    $alphabet = array_flip(range("a", "h"));

    return [$alphabet[$position[0]], 8 - $position[1]];
}

//Return the position of a piece in board format
function arrayToBoardPosition(int $x, int $y): string {
    $alphabet = range("a", "h");

    return $alphabet[$x] . (8 - $y);
}

$board = array_fill(0, 8, str_repeat("-", 8));

$rookPosition = trim(fgets(STDIN));
[$rookX, $rookY] = boardToArrayPosition($rookPosition);

fscanf(STDIN, "%d", $nbPieces);
//Add the other pieces on the board
for ($i = 0; $i < $nbPieces; $i++) {
    fscanf(STDIN, "%d %s", $color, $position);

    [$x, $y] = boardToArrayPosition($position);

    $board[$y][$x] = $color;
}

$moves = [];
$checks = [[1, 0, 1], [-1, 0, 1], [0, 1, 1], [0, -1, 1]];

//Check the rook moving in the 4 directions
for($i = 1; $i < 8; ++$i) {
    foreach($checks as [$x, $y, &$check]) {
        if(!$check) continue; //No longer checking this direction

        $checkX = $rookX + $x * $i;
        $checkY = $rookY + $y * $i;

        //Outside of the board, we are done with this direction
        if($checkX < 0 || $checkX > 7 || $checkY < 0 || $checkY > 7) {
            $check = 0;
            continue;
        }

        switch($board[$checkY][$checkX]) {
            case '-': $moves[] = "R" . $rookPosition . "-" . arrayToBoardPosition($checkX, $checkY); break;
            case 1: $moves[] = "R" . $rookPosition . "x" . arrayToBoardPosition($checkX, $checkY);
            case 0: $check = 0;
        }
    }
}

sort($moves, SORT_NATURAL); //ascending lexicographical ASCII order

echo implode("\n", $moves) . PHP_EOL;
