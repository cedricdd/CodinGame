<?php

fscanf(STDIN, "%d", $sideSize);
for ($i = 0; $i < $sideSize; $i++) {
    $grid[] = str_replace(".", "0", trim(fgets(STDIN)));
}

$size = $sideSize >> 1;

foreach([[0, 0], [$size, 0], [0, $size], [$size, $size]] as $i => [$xs, $ys]) {

    $sum = 0;

    for($y = $ys; $y < $ys + $size; ++$y) {
        for($x = $xs; $x < $xs + $size; ++$x) {
            $sum += intval($grid[$y][$x]);
        }
    }

    $quads[$sum][] = $i + 1;
}

[$f, $l] = array_keys($quads);

if(count($quads[$f]) == 1) echo "Quad-" . $quads[$f][0] . " is Odd-Quad-Out" . PHP_EOL . "It has value of $f" . PHP_EOL . "Others have value of $l" . PHP_EOL;
else echo "Quad-" . $quads[$l][0] . " is Odd-Quad-Out" . PHP_EOL . "It has value of $l" . PHP_EOL . "Others have value of $f" . PHP_EOL;
