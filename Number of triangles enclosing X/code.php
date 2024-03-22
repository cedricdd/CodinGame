<?php

function area(float $x1, float $y1, float $x2, float $y2, float $x3, float $y3): float {
    return abs(($x1 * ($y2 - $y3) + 
                $x2 * ($y3 - $y1) +  
                $x3 * ($y1 - $y2)) / 2.0);
}

function isInside(float $x1, float $y1, float $x2, float $y2, float $x3, float $y3, float $x, float $y): bool { 
     
    /* Calculate area of triangle ABC */
    $A = area($x1, $y1, $x2, $y2, $x3, $y3);
     
    /* Calculate area of triangle PBC */
    $A1 = area($x, $y, $x2, $y2, $x3, $y3);
     
    /* Calculate area of triangle PAC */
    $A2 = area($x1, $y1, $x, $y, $x3, $y3);
     
    /* Calculate area of triangle PAB */
    $A3 = area($x1, $y1, $x2, $y2, $x, $y);
     
    /* Check if sum of A1, A2 and A3 is same as A */
    return (round($A, 10) == round($A1 + $A2 + $A3, 10));
}

$input = trim(fgets(STDIN));

[$x, $y] = explode(";", substr($input, strpos($input, " ") + 1));

error_log("$x $y");

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    [$name, $coord] = explode(" ", trim(fgets(STDIN)));
    $points[] = array_map("floatval", explode(";", $coord));
}

$count = 0;

for($i1 = 0; $i1 < $N; ++$i1) {
    for($i2 = $i1 + 1; $i2 < $N; ++$i2) {
        for($i3 = $i2 + 1; $i3 < $N; ++$i3) {
            if(isInside($points[$i1][0], $points[$i1][1], $points[$i2][0], $points[$i2][1], $points[$i3][0], $points[$i3][1], $x, $y)) {
                ++$count;
            }
        }
    }
}

echo $count . PHP_EOL;
