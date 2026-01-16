<?php

fscanf(STDIN, "%d", $N);

$layerSize = $N * $N;
$moves = [];
$dirs = [
    'L' => -1,
    'R' =>  1,
    'D' => -$N,
    'U' =>  $N,
    'B' => -$layerSize,
    'F' =>  $layerSize,
];
$masks = [];

for($i = 0; $i < $layerSize * $N; ++$i) $masks[$i] = 1 << $i;

for($z = 0; $z < $N; ++$z) {
    for($y = 0; $y < $N; ++$y) {
        for($x = 0; $x < $N; ++$x) {
            $index = $z * $layerSize + $y * $N + $x;
            error_log("$x $y $z -- $index");

            for ($i = 1; $i < 4; $i++) {
                foreach ($dirs as $dir => $step) {
                    // Boundary checks
                    if (($dir === 'L' && $x < $i) ||
                        ($dir === 'R' && $x + $i >= $N) ||
                        ($dir === 'D' && $y < $i) ||
                        ($dir === 'U' && $y + $i >= $N) ||
                        ($dir === 'B' && $z < $i) ||
                        ($dir === 'F' && $z + $i >= $N)) {
                        continue;
                    }

                    $hash = 0;
                    for ($j = 1; $j <= $i; $j++) {
                        $index2 = $index + $j * $step;
                        $hash |= $masks[$index2];
                    }

                    $moves[$index][$i][$dir][$index2] = $hash;
                }
            }
        }
    }
}

error_log(var_export($moves, 1));

$blocks = stream_get_line(STDIN, 256 + 1, "\n");
$break = strlen($blocks);
$solutions = [];

sort($solutions);

echo implode(PHP_EOL, $solutions);
