<?php

$alphabet = array_flip(range("A", "Z"));

fscanf(STDIN, "%d", $N);
for ($y = 0; $y < $N; ++$y) {
    $line = trim(fgets(STDIN));

    error_log($line);

    foreach(str_split($line) as $x => $c) {
        $map[$y][$x] = $alphabet[$c];
        //On the border use real height, otherwise assume it's full to the max, ie 25
        $water[$y][$x] = ($x == 0 || $y == 0 || $x == $N - 1 || $y == $N - 1) ? $alphabet[$c] : 25;
    }
}

do {
    $explore = false;

    for($y = 1; $y < $N - 1; ++$y) {
        for($x = 1; $x < $N - 1; ++$x) {
            //Check if water can move to one of the 4 neighbors, it can't go below the height value
            $value = max($map[$y][$x], min($water[$y][$x + 1], $water[$y][$x - 1], $water[$y + 1][$x], $water[$y - 1][$x]));

            //Some water is moving
            if($value != $water[$y][$x]) {
                $explore = true;

                $water[$y][$x] = $value;
            }
        }
    }

} while($explore);

$sumWater = 0;

for($y = 1; $y < $N - 1; ++$y) {
    for($x = 1; $x < $N - 1; ++$x) {
        //If the max water at the position is above the height of the position it will hold some water
        if($water[$y][$x] > $map[$y][$x]) $sumWater += $water[$y][$x] - $map[$y][$x];
    }
}

echo $sumWater . PHP_EOL;
