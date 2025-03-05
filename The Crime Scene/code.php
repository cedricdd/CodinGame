<?php

//Andrew's monotone chain
function convexHull(array $points): array {
    // Sort points lexicographically (by x, then by y)
    usort($points, function (array $a, array $b) {
        return ($a[0] <=> $b[0]) ?: ($a[1] <=> $b[1]);
    });

    // Function to compute cross product of vectors AB and AC
    function crossProduct($a, $b, $c) {
        return ($b[0] - $a[0]) * ($c[1] - $a[1]) - ($b[1] - $a[1]) * ($c[0] - $a[0]);
    }

    // Build lower hull
    $lower = [];
    foreach ($points as $p) {
        while (count($lower) >= 2 && crossProduct($lower[count($lower) - 2], $lower[count($lower) - 1], $p) <= 0) {
            array_pop($lower);
        }
        $lower[] = $p;
    }

    // Build upper hull
    $upper = [];
    $points = array_reverse($points);
    foreach ($points as $p) {
        while (count($upper) >= 2 && crossProduct($upper[count($upper) - 2], $upper[count($upper) - 1], $p) <= 0) {
            array_pop($upper);
        }
        $upper[] = $p;
    }

    // Remove last point of each half because it is repeated
    array_pop($lower);
    array_pop($upper);

    // Merge lower and upper hull
    return array_merge($lower, $upper);
}

$size = 2 * pi() * 3;

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $X, $Y);

    $points[] = [$X, $Y];
}

if(count($points) > 1) {
    $hull = convexHull($points);
    $count = count($hull);

    //Calculate the distance between each points
    for($i = 0; $i < $count; ++$i) {
        $size += sqrt(($hull[$i][0] - $hull[($i + 1) % $count][0]) ** 2 + ($hull[$i][1] - $hull[($i + 1) % $count][1]) ** 2);
    }
}

echo ceil($size / 5) . PHP_EOL;
