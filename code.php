<?php

$start = microtime(1);

fscanf(STDIN, "%d", $n);

for($y = 0; $y < $n; ++$y) {
    for($x = 0; $x < $n; ++$x) {
        
        //If we place a queen at position $x;$y, find all the positions where we can't place another queen
        $positions = [];

        //Vertical & horizontal positions
        for($i = 0; $i < $n; ++$i) {
            $positions[$y * $n + $i]= 1;
            $positions[$i * $n + $x]= 1;
        }

        //Diagonal positions
        for($i = 1; $i < $n; ++$i) {
            foreach([[-1, -1], [1, -1], [-1, 1], [1, 1]] as [$xm, $ym]) {
                $xu = $x + ($xm * $i);
                $yu = $y + ($ym * $i);

                if($xu >= 0 && $xu < $n && $yu >= 0 && $yu < $n) $positions[$yu * $n + $xu]= 1;
            }
        }

        $affectedPositions[$y * $n + $x] = $positions;
    }
}

function solve(array $allowedPositions, int $y): int {

    global $n, $affectedPositions;

    if($y == $n) return 1; //We have placed a queen on each row => we have placed n queens

    $solutions = 0;

    foreach($allowedPositions as $index => $filler) {
        $positionY = intdiv($index, $n);

        if($positionY != $y) break; //We only want to test all the queens we can place on row $y

        //Continue with next row and the updated list of allowed positions
        $solutions += solve(array_diff_key($allowedPositions, $affectedPositions[$index]), $y + 1);
    }

    return $solutions;
}

echo solve(array_fill(0, $n * $n, 1), 0) . PHP_EOL;

error_log(microtime(1) - $start);
