<?php

$start = microtime(1);

fscanf(STDIN, "%d %d", $W, $H);
fscanf(STDIN, "%d", $X);
for ($i = 0; $i < $H; $i++) {
    $matrix[] = explode(" ", trim(fgets(STDIN)));
}

$matrixUpdated = array_fill(0, $H, array_fill(0, $W, 0));

for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        $level = min($x, $y, $W - $x - 1, $H - $y - 1);

        //No displacement for this position
        if($level == intdiv(min($W, $H), 2)) $matrixUpdated[$y][$x] = $matrix[$y][$x];
        else {
            //Get the current position in the loop
            if($x == $level) $position = $y - $level; //Left
            elseif($H - $y - 1 == $level) $position = ($H - $level * 2) + $x - ($level + 1); //Bottom
            elseif($W - $x - 1 == $level) $position = ($H - $level * 2) + ($W - $level * 2 - 1) + ($H - $y - $level - 2); //Right
            else $position = ($H - $level * 2) * 2 + ($W - ($level + 1) * 2) + ($W - $x - $level - 2); //Top

            $size = ($W - $level * 2) * 2 + ($H - ($level + 1) * 2) * 2; //Number of positions in the loop

            $shift = ($position + $X) % $size;

            //If the final position in the loop is on the left
            $newX = $level;
            $newY = $level;

            if($shift < ($H - $level * 2)) {
                $matrixUpdated[$newY + $shift][$newX] = $matrix[$y][$x];
                continue;
            }

            //If the final position in the loop is on the bottom
            $shift -= ($H - $level * 2);
            $newY = $H - $level - 1;
            $newX = $level + 1;

            if($shift < ($W - $level * 2 - 1)) {
                $matrixUpdated[$newY][$newX + $shift] = $matrix[$y][$x];
                continue;
            }

            //If the final position in the loop is on the right
            $shift -= ($W - $level * 2 - 1);
            $newY = $H - $level - 2;
            $newX = $W - $level - 1;

            if($shift < ($H - $level * 2 - 1)) {
                $matrixUpdated[$newY - $shift][$newX] = $matrix[$y][$x];
                continue;
            }

            //The final position in the loop is on the top
            $shift -= ($H - $level * 2 - 1);
            $newY = $level;
            $newX = $W - $level - 2;

            $matrixUpdated[$newY][$newX - $shift] = $matrix[$y][$x];
        }
    }
}

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $matrixUpdated)) . PHP_EOL;

error_log(microtime(1) - $start);
