<?php

//Check if the Mandelbrot set is diverging
function mandelbort(float $cr, float $ci, int $steps): bool {

    [$nr, $ni] = [0, 0];
 
    for($i = 1; $i <= $steps; ++$i) {
        [$nr, $ni] = [$nr ** 2 - $ni ** 2 + $cr, 2 * $nr * $ni + $ci];
    }

    return sqrt($nr ** 2 + $ni ** 2) <= 1.0;
}

fscanf(STDIN, "%d", $n);

$step = 2 / ($n - 1);

for($y = -1.0; number_format($y, 2) <= 1.0; $y += $step) {
    $line = "";

    for($x = -2.0; number_format($x, 2) <= 1.0; $x += $step) {
        $line .= mandelbort($x, $y, 10) ? "*" : " ";
    }

    echo $line . PHP_EOL;
}
