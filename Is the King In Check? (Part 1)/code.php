<?php

function checkRookMoves(int $x, int $y, string $king): bool {
    for($i = 0; $i < 8; ++$i) {
        if($king == ($x + $i) . ";" . $y || 
           $king == ($x - $i) . ";" . $y || 
           $king == $x . ";" . ($y + $i) || 
           $king == $x . ";" . ($y - $i)) return true; 
    }

    return false;
}

function checkBishopMoves(int $x, int $y, string $king): bool {
    for($i = 0; $i < 8; ++$i) {
        if($king == ($x + $i) . ";" . ($y + $i) || 
           $king == ($x - $i) . ";" . ($y + $i) || 
           $king == ($x + $i) . ";" . ($y - $i) || 
           $king == ($x - $i) . ";" . ($y - $i)) return true; 
    }

    return false;
}

function checkKnightMoves(int $x, int $y, string $king): bool {
    foreach([[-2, -1], [-1, -2], [1, -2], [2, -1], [2, 1], [1, 2], [-1, 2], [-2, 1]] as [$xm, $ym]) {
        if($king == ($x + $xm) . ";" . ($y + $ym)) return true; 
    }

    return false;
}

for ($y = 0; $y < 8; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $c) {
        if($c == "K") $king = $x . ";" . $y;
        elseif($c != "_") [$type, $px, $py] = [$c, $x, $y];
    }
}

switch($type) {
    case "R": if(checkRookMoves($px, $py, $king)) exit("Check"); break;
    case "B": if(checkBishopMoves($px, $py, $king)) exit("Check"); break;
    case "Q": if(checkRookMoves($px, $py, $king) || checkBishopMoves($px, $py, $king)) exit("Check"); break;
    case "N": if(checkKnightMoves($px, $py, $king)) exit("Check"); break;
}

echo "No Check" . PHP_EOL;
