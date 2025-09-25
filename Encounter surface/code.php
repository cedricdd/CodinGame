<?php

function sortPolygonVertices(array $points): array {
    $cx = 0.0; 
    $cy = 0.0;
    $n = 0;

    // Compute centroid
    foreach ($points as $p) {
        $cx += $p[0];
        $cy += $p[1];
        ++$n;
    }

    $cx /= $n;
    $cy /= $n;

    // Sort by angle around centroid
    usort($points, function($a, $b) use ($cx, $cy) {
        $angA = atan2($a[1] - $cy, $a[0] - $cx);
        $angB = atan2($b[1] - $cy, $b[0] - $cx);

        if ($angA == $angB) return 0;
        return ($angA < $angB) ? -1 : 1;
    });

    return $points; // CCW order
}

// Check if point p is inside edge a->b (left side or on line)
function isInside(array $p, array $a, array $b): bool {
    $cross = ($b[0]-$a[0])*($p[1]-$a[1]) - ($b[1]-$a[1])*($p[0]-$a[0]);

    return $cross >= -1e-12; // small tolerance
}

// Intersection of line segments p1-p2 and q1-q2
function lineIntersection(array $p1, array $p2, array $q1, array $q2): array {
    [$x1,$y1] = $p1;
    [$x2,$y2] = $p2;
    [$x3,$y3] = $q1;
    [$x4,$y4] = $q2;

    $denom = ($x1-$x2)*($y3-$y4) - ($y1-$y2)*($x3-$x4);

    if (abs($denom) < 1e-12) {
        // parallel lines, just return midpoint of overlap
        return [($x1+$x2)/2.0, ($y1+$y2)/2.0];
    }

    $px = (($x1*$y2 - $y1*$x2)*($x3-$x4) - ($x1-$x2)*($x3*$y4 - $y3*$x4)) / $denom;
    $py = (($x1*$y2 - $y1*$x2)*($y3-$y4) - ($y1-$y2)*($x3*$y4 - $y3*$x4)) / $denom;

    return [$px, $py];
}

// Sutherland–Hodgman polygon clipping
function sutherlandHodgman(array $subject, array $clip): array {
    $output = $subject;

    foreach ($clip as $i => $A) {
        $B = $clip[($i+1) % count($clip)];
        $input = $output;
        $output = [];

        if (empty($input)) break;

        $S = $input[count($input)-1];
        foreach ($input as $E) {
            if (isInside($E, $A, $B)) {
                if (isInside($S, $A, $B)) {
                    $output[] = $E;
                } else {
                    $output[] = lineIntersection($S, $E, $A, $B);
                    $output[] = $E;
                }
            } else {
                if (isInside($S, $A, $B)) {
                    $output[] = lineIntersection($S, $E, $A, $B);
                }
            }
            $S = $E;
        }
    }

    return $output;
}

function polygonArea(array $polygon): float {
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

// Compute intersection area of two convex polygons
function convexIntersectionArea(array $p1, array $p2): array {
    if (count($p1) < 3 || count($p2) < 3) {
        return [0.0, []];
    }

    $intersect = sutherlandHodgman($p1, $p2);

    if (empty($intersect)) return [0.0, []];

    $area = polygonArea($intersect);

    return [$area, $intersect];
}

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d", $m);

for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d", $x1, $y1);
    $p1[] = [$x1, $y1];
}

$p1 = sortPolygonVertices($p1);

for ($i = 0; $i < $m; $i++) {
    fscanf(STDIN, "%d %d", $x2, $y2);
    $p2[] = [$x2, $y2];
}

$p2 = sortPolygonVertices($p2);

[$area, $intersect] = convexIntersectionArea($p1, $p2);

error_log("Intersection area: " . $area);
error_log("Intersection polygon vertices:");
foreach ($intersect as $p) {
    error_log( $p[0] . ", " . $p[1]);
}

echo ceil($area) . PHP_EOL;
