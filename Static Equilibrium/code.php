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

if($x > 0 && $y < 0) echo format(360 - rad2deg(atan(abs($y) / $x)));
elseif($x < 0 && $y < 0) echo format(180 + rad2deg(atan(abs($y) / abs($x))));
elseif($x < 0 && $y > 0) echo format(180 - rad2deg(atan($y / abs($x))));
elseif($x > 0 && $y > 0) echo format(rad2deg(atan($y / $x)));
elseif($x == 0 && $y < 0) echo "270.00" . PHP_EOL;
elseif($x < 0 && $y == 0) echo "180.00" . PHP_EOL;
elseif($x == 0 && $y > 0) echo "90.00" . PHP_EOL;
else echo "0.00" . PHP_EOL;
