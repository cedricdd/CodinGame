<?php

function checkMoves(int $x, int $y, array $board, bool $diagonal): bool {
    if($diagonal) $directions = [[1, 1, 1], [1, -1, 1], [-1, 1, 1], [-1, -1, 1]];
    else $directions = [[0, 1, 1], [0, -1, 1], [1, 0, 1], [-1, 0, 1]];

    for($i = 1; $i < 8; ++$i) {
        foreach($directions as [$xm, $ym, &$active]) {
            if(!$active) continue;

            $xu = $x + ($xm * $i);
            $yu = $y + ($ym * $i);

            if(($board[$yu][$xu] ?? "_") == "k") return true; //Checkmate
            elseif($xu < 0 || $xu > 7 || $yu < 0 || $yu > 7 || $board[$yu][$xu] != "_") $active = 0; //Outside of board or blocked by another piece
        }
    }

    return false;
}

function checkKnightMoves(int $x, int $y, array $board): bool {
    foreach([[-2, -1], [-1, -2], [1, -2], [2, -1], [2, 1], [1, 2], [-1, 2], [-2, 1]] as [$xm, $ym]) {
        if(($board[$y + $ym][$x + $xm] ?? "_") == "k") return true; 
    }

    return false;
}

for ($y = 0; $y < 8; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $c) {
        if($c != "_" && $c != "k") $pieces[] = [$c, $x, $y];
        $board[$y][$x] = $c;
    }
}

foreach($pieces as [$type, $x, $y]) {
    switch($type) {
        case "R": if(checkMoves($x, $y, $board, 0)) exit("Check"); break;
        case "B": if(checkMoves($x, $y, $board, 1)) exit("Check"); break;
        case "Q": if(checkMoves($x, $y, $board, 0) || checkMoves($x, $y, $board, 1)) exit("Check"); break;
        case "N": if(checkKnightMoves($x, $y, $board)) exit("Check"); break;
    }
}

echo "No Check" . PHP_EOL;
