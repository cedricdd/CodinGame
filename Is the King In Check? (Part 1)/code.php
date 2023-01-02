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
        if($c != "_") $pieces[$c] = $x . ";" . $y;
    }
}

if(isset($pieces["R"])) {
    [$x, $y] = explode(";", $pieces["R"]);

    if(checkRookMoves($x, $y, $pieces["K"])) exit("Check");
} elseif(isset($pieces["B"])) {
    [$x, $y] = explode(";", $pieces["B"]);

    if(checkBishopMoves($x, $y, $pieces["K"])) exit("Check");
} elseif(isset($pieces["Q"])) {
    [$x, $y] = explode(";", $pieces["Q"]);

    if(checkRookMoves($x, $y, $pieces["K"]) || checkBishopMoves($x, $y, $pieces["K"])) exit("Check");
} elseif(isset($pieces["N"])) {
    [$x, $y] = explode(";", $pieces["N"]);

    if(checkKnightMoves($x, $y, $pieces["K"])) exit("Check");
}

echo "No Check" . PHP_EOL;
