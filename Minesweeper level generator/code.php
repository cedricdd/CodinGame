<?php

const MODULO = 4294967296;

function getRandom(): int {
    global $random;
    
    return $random = floor((((214013 * $random) % MODULO + 2531011) % MODULO) / 65536);
}

function setBomb(array &$map, int $xb, int $yb): void {
    global $width, $height;

    $map[$yb][$xb] = "#";

    //Update the count on the neighboring cells
    for($y = max(0, $yb - 1); $y < min($height, $yb + 2); ++$y) {
        for($x = max(0, $xb - 1); $x < min($width, $xb + 2); ++$x) {
            if($map[$y][$x] == "#") continue;
            else $map[$y][$x] = intval($map[$y][$x]) + 1;
        }
    }
}

fscanf(STDIN, "%d %d %d %d %d %d", $width, $height, $mines, $xs, $ys, $random);

$map = array_fill(0, $height, str_repeat(".", $width));

//The 3x3 cells square centered on this cell is always set free of mines.
for($y = max(0, $ys - 1); $y < min($height, $ys + 2); ++$y) {
    for($x = max(0, $xs - 1); $x < min($width, $xs + 2); ++$x) {
        $forbidden[$y][$x] = 1;
    }
}
   
//Place all the mines
while(true) {
    $x = getRandom() % $width;
    $y = getRandom() % $height;

    error_log("X $x -- Y $y");

    if(!isset($forbidden[$y][$x])) {
        setBomb($map, $x, $y);
        $forbidden[$y][$x] = 1;

        if(--$mines == 0) break;
    }
}

echo implode("\n", $map) . PHP_EOL;
?>
