<?php

$lines = [];
$points = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d %d %d", $x1, $y1, $x2, $y2);

    $a1 = $y2 - $y1;
    $b1 = $x1 - $x2;
    $c1 = $a1 * $x1 + $b1 * $y1;

    foreach($lines as [$a2, $b2, $c2]) {
        $D = $a1 * $b2 - $a2 * $b1;

        if($D != 0) {
            $x = number_format(($c1 * $b2 - $c2 * $b1) / $D, 3, '.', '');
            $y = number_format(($a1 * $c2 - $a2 * $c1) / $D, 3, '.', '');

            $points[] = [$x, $y];
        }
    }

    $lines[] = [$a1, $b1, $c1];
}

$points = array_unique($points, SORT_REGULAR);

usort($points, function($a, $b) {
    if($a[0] == $b[0]) return $a[1] <=> $b[1];
    else return $a[0] <=> $b[0];
});

echo count($points) . PHP_EOL;

echo implode(PHP_EOL, array_map(function($point){
    return implode(" ", $point);
}, $points)); 
