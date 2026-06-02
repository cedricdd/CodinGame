<?php

function format(float $n, int $precision = 2): string {
    return number_format($n, $precision, '.', '') . PHP_EOL;
}

$forces = ['UP' => 0, 'DOWN' => 0, 'LEFT' => 0, 'RIGHT' => 0];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %s", $f, $dir);

    $forces[$dir] += $f;
}

$x = ($forces['RIGHT'] - $forces['LEFT']) * -1;
$y = ($forces['UP'] - $forces['DOWN']) * -1;

echo format(sqrt($x ** 2 + $y ** 2));
echo format(fmod(rad2deg(atan2($y, $x)) + 360, 360));
