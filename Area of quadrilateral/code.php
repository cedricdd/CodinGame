<?php

function getAngleToPoint(int $x, int $y, int $px, int $py): float {
    $distance = sqrt(($x - $px) ** 2 + ($y - $py) ** 2);
    $dx = ($px - $x) / $distance;
    $dy = ($py - $y) / $distance;

    $angleToPoint = rad2deg(acos($dx));

    // If the point I want is below me, I have to shift the angle for it to be correct
    if ($dy < 0) {
        $angleToPoint = 360.0 - $angleToPoint;
    }

    return $angleToPoint;
}

$cx = 0;
$cy = 0;

for ($i = 0; $i < 4; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $points[] = [$x, $y];
    $cx += $x;
    $cy += $y;
}

$cx /= 4;
$cy /= 4;

//Get the angle from the center of the quadrilateral to each points
foreach($points as $i => [$x, $y]) $points[$i][2] = getAngleToPoint($cx, $cy, $x, $y);

//Order the coordinates
usort($points, function($a, $b) {
    return $a[2] <=> $b[2];
});

/**
 * Applying the Shoelace Formula
 * A = 1/2 * (x1​y2​+x2​y3​+x3​y4​+x4​y1​−y1​x2​−y2​x3​−y3​x4​−y4​x1​)
 */

echo floor(1/2 * ($points[0][0] * $points[1][1] + $points[1][0] * $points[2][1] + $points[2][0] * $points[3][1] + $points[3][0] * $points[0][1] - $points[1][0] * $points[0][1] - $points[2][0] * $points[1][1] - $points[3][0] * $points[2][1] - $points[0][0] * $points[3][1])) . PHP_EOL;
