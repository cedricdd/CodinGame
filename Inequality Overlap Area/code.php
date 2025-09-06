<?php

$polygon = [
    [-1000, 1000],
    [1000, 1000],
    [1000, -1000],
    [-1000, -1000]
];

function inside(array $point, float $a, float $b, float $c): bool {
    [$x, $y] = $point;
    return $a * $x + $b * $y <= $c + 1e-9; // small epsilon for float tolerance
}

//Get the intersection of the segment defined by the points p1 & p2 and the line ax + by = c
function intersect(array $p1, array $p2, float $a, float $b, float $c): array {
    [$x1, $y1] = $p1;
    [$x2, $y2] = $p2;

    $v1 = $a * $x1 + $b * $y1 - $c;
    $v2 = $a * $x2 + $b * $y2 - $c;

    $t = $v1 / ($v1 - $v2); 
    return [
        round($x1 + $t * ($x2 - $x1), 8),
        round($y1 + $t * ($y2 - $y1), 8)
    ];
}

function polygonArea($polygon): float {
    $n = count($polygon);
    if ($n < 3) return 0.0; // not a polygon

    $sum = 0;
    for ($i = 0; $i < $n; $i++) {
        [$x1, $y1] = $polygon[$i];
        [$x2, $y2] = $polygon[($i + 1) % $n];
        $sum += ($x1 * $y2 - $x2 * $y1);
    }

    return abs($sum) / 2.0;
}

// Clip the current polygon with the half plane that does not satisfy the equation
function clipPolygon($polygon, $a, $b, $c) {
    $output = [];
    $n = count($polygon);

    for ($i = 0; $i < $n; $i++) {
        $current = $polygon[$i];
        $prev = $polygon[($i - 1 + $n) % $n];

        $insideCurrent = inside($current, $a, $b, $c);
        $insidePrev = inside($prev, $a, $b, $c);

        if ($insidePrev && $insideCurrent) {
            // both inside → keep current
            $output[] = $current;
        } elseif ($insidePrev && !$insideCurrent) {
            // leaving → add intersection
            $output[] = intersect($prev, $current, $a, $b, $c);
        } elseif (!$insidePrev && $insideCurrent) {
            // entering → add intersection + current
            $output[] = intersect($prev, $current, $a, $b, $c);
            $output[] = $current;
        }
        // else: both outside → keep nothing
    }

    return $output;
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $inequality = stream_get_line(STDIN, 30 + 1, "\n");

    preg_match("/(-?[0-9\.]+)x ([+-]) (-?[0-9\.]+)y (<=|>=) (-?[0-9\.]+)/", $inequality, $matches);

    $a = $matches[1];
    $b = $matches[3];
    $c = $matches[5];

    // We want everthing in the format aX + bY <= c
    if($matches[2] == '-') $b *= -1;
    if($matches[4] == ">=") {
        $a *= -1;
        $b *= -1;
        $c *= -1;
    }

    $polygon = clipPolygon($polygon, $a, $b, $c);
}

if(!$polygon) echo "No Overlap" . PHP_EOL;
else {
    foreach($polygon as [$x, $y]) {
        if($x == 1000 || $y == 1000) {
            exit("Overlap, But Infinite");
        }
    }

    $area = polygonArea($polygon);

    echo $area == 0.0 ? "No Overlap" : number_format(polygonArea($polygon), 3, '.', '') . PHP_EOL;
}
