<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $L);

$cells = array_fill(0, $N*$N, 1);

for ($cy = 0; $cy < $N; $cy++) {
    foreach(explode(" ", trim(fgets(STDIN))) as $cx => $cell) {
        if($cell == "C") { //We found a candle, unset all cells affected by this candle
            for ($y = max(0, $cy - $L + 1); $y < min($N, $cy + $L); $y++) {
                for ($x = max(0, $cx - $L + 1); $x < min($N, $cx + $L); $x++) {
                    unset($cells[($y * $N) + $x]);
                }
            }
        } 
    }
}

echo count($cells) . "\n";
?>
