<?php

const PIECES = [
    [[0, 0], [1, 0], [2, 0], [0, 1]],
    [[0, 0], [1, 0], [1, 1], [1, 2]],
    [[0, 0], [1, 0], [2, 0], [2, -1]],
    [[0, 0], [0, 1], [0, 2], [1, 2]],
    [[0, 0], [1, 0], [2, 0], [2, 1]],
    [[0, 0], [1, 0], [1, -1], [1, -2]],
    [[0, 0], [0, 1], [1, 1], [2, 1]],
    [[0, 0], [1, 0], [0, 1], [0, 2]],
];

function nCk(int $n, int $k): int {
    if ($k < 0 || $k > $n) {
        return 0; // no valid combinations
    }

    $result = 1;
    for ($i = 1; $i <= $k; $i++) {
        $result = $result * ($n - $i + 1) / $i;
    }

    return (int)$result;
}

fscanf(STDIN, "%d %d %d", $height, $width, $n);

if($width * $height - ($n + 8) < 0) echo '0' . PHP_EOL;
else {
    $total = 0;
    $lID = 0;
    $positions = [];
    $test = 0;
    $pieces = [];

    for($index = 0, $y = 0; $y < $height; ++$y) {
        for($x = 0; $x < $width; ++$x, ++$index) {
            $count = 0;
        
            //Check if each pieces can 'start' at this position
            foreach(PIECES as $i => $listPositions) {
                $list = [];

                foreach($listPositions as $j => [$xm, $ym]) {
                    $xu = $x + $xm;
                    $yu = $y + $ym;

                    if($xu < 0 || $yu < 0 || $xu >= $width || $yu >= $height) continue 2; //Outside of the board

                    $list[] = $yu * $width + $xu;
                }

                ++$count;
                $positions[$index][] = $list;

                foreach($list as $indexPosition) $pieces[$indexPosition][$lID] = 1; //Add the pieces ID to each positions

                ++$lID;
            }

            $total += $count;
        }
    }
}

$result = 0;

for($index = ($width * $height) - 1; $index >= 0; --$index) {
    if(!isset($positions[$index])) continue;

    foreach($positions[$index] as $list) {
        $listPieces = [];

        //Get all the pieces we can no longer use by placing the current one
        foreach($list as $indexPosition) {
            $listPieces += $pieces[$indexPosition];
        }

        $result += $$total - count($listPieces);
    }   
}

//We need to multiply by the number of way to place the neutral blocks
echo $total * nCk($width * $height - 8, $n) . PHP_EOL;
