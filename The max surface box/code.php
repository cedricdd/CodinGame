<?php

fscanf(STDIN, "%d", $N);

//The smallest possible is a cube
for($x = ceil($N ** (1/3)); $x >= 1; --$x) {
    if($N % $x != 0) continue;

    for($y = ceil(sqrt($N / $x)); $y >= 1; --$y) {
        if($N % ($x * $y) != 0) continue;

        $z = $N / ($x * $y);

        $solutions["$x $y $z"] = 2 * ($x * $y + $y * $z + $z * $x);
    }
}

echo min($solutions) . " " . max($solutions) . PHP_EOL;
