<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $points[] = [$x, $y];
}

$area = 0;

for($i = 0; $i < $N; ++$i) {
    $area += ($points[$i][0] * $points[($i + 1) % $N][1] - $points[($i + 1) % $N][0] * $points[$i][1]);
}

echo ($area > 0 ? "COUNTERCLOCKWISE" : "CLOCKWISE") . PHP_EOL;
