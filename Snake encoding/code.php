<?php
fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $X);

//Pre-fill the array so it's in right order for output
$grid = array_fill(0, $N, array_fill(0, $N, ""));

for ($y = 0; $y < $N; $y++) {
    //Some character in the last validator is using more than one byte
    foreach(preg_split("//u", trim(fgets(STDIN)), -1, PREG_SPLIT_NO_EMPTY) as $x => $c) {
        $moves = $X + (($x & 1) ? $y : $N - 1 - $y); //The number of moves adjusted to the position of the character
        $finalX = ($x + intdiv($moves, $N)) % $N; //The final X position of the character
        $finalY = ($finalX & 1) ? ($moves % $N) : $N - 1 - ($moves % $N); //The final Y position of the character
        $grid[$finalY][$finalX] = $c;
    }
}

echo implode("\n", array_map('implode', $grid)) . PHP_EOL;
