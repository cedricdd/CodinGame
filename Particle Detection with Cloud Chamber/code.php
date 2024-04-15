<?php

const PARTICLES = [
    "Electron" => [-1, 0.511, "e-"],
    "Proton" => [1, 938.0, "p+"],
    "Alpha" => [2, 3757.0, "alpha"],
    "Pion" => [1, 140.0, "pi+"],
];
const C = 299792458;

function matrix(array $m): int {
    return $m[0][0] * ($m[1][1] * $m[2][2] - $m[1][2] * $m[2][1]) - $m[0][1] * ($m[1][0] * $m[2][2] - $m[1][2] * $m[2][0]) + $m[0][2] * ($m[1][0] * $m[2][1] - $m[1][1] * $m[2][0]);
}

fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%f", $B);
fscanf(STDIN, "%f", $V);

$gamma = 1 / sqrt(1 - $V * $V);
$pointsY = [];
$pointsX = [];
$minX = $minY = INF;
$maxX = $maxY = -INF;

for ($y = 0; $y < $h; ++$y) {
    //Find all the points part of the trajectory
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if($c == ' ') {
            $pointsY[$y][] = $x;
            $pointsX[$x][] = $y;

            if($x < $minX) $minX = $x;
            if($y < $minY) $minY = $y;
            if($x > $maxX) $maxX = $x;
            if($y > $maxY) $maxY = $y;
        }
    }
}

//The biggest difference is on the X axis, use it to select the 3 points
if($maxX - $minX >= $maxY - $minY) {
    $middle = intdiv(($maxX - $minX), 2) + $minX;

    $p1 = [$minX, reset($pointsX[$minX])];
    $p2 = [$middle, reset($pointsX[$middle])];
    $p3 = [$maxX, reset($pointsX[$maxX])];

} //The biggest difference is on the Y axis, use it to select the 3 points
else {
    $middle = intdiv(($maxY - $minY), 2) + $minY;

    $p1 = [$minY, reset($pointsY[$minY])];
    $p2 = [$middle, reset($pointsY[$middle])];
    $p3 = [$maxY, reset($pointsY[$maxY])];
}

/**
 * http://web.archive.org/web/20161011113446/http://www.abecedarical.com/zenosamples/zs_circle3pts.html
 * To find the center and the radius we work with the matrix:
 * x²+y²   | x  | y  | 1
 * x1²+y1² | x1 | y1 | 1
 * x2²+y2² | x2 | y2 | 1
 * x3²+y3² | x3 | y3 | 1
 */

$m11 = matrix([[$p1[0], $p1[1], 1], [$p2[0], $p2[1], 1], [$p3[0], $p3[1], 1]]); //mxy => we solve the m after removing the row x and col y

//It's not a circle, it's a neutron
if($m11 == 0) exit("n0 inf");

$m12 = matrix([[$p1[0] ** 2 + $p1[1] ** 2, $p1[1], 1], [$p2[0] ** 2 + $p2[1] ** 2, $p2[1], 1], [$p3[0] ** 2 + $p3[1] ** 2, $p3[1], 1]]);
$m13 = matrix([[$p1[0] ** 2 + $p1[1] ** 2, $p1[0], 1], [$p2[0] ** 2 + $p2[1] ** 2, $p2[0], 1], [$p3[0] ** 2 + $p3[1] ** 2, $p3[0], 1]]);
$m14 = matrix([[$p1[0] ** 2 + $p1[1] ** 2, $p1[0], $p1[1]], [$p2[0] ** 2 + $p2[1] ** 2, $p2[0], $p2[1]], [$p3[0] ** 2 + $p3[1] ** 2, $p3[0], $p3[1]]]);

$x0 = 0.5 * ($m12 / $m11); //X coordinate of the center
$y0 = -0.5 * ($m13 / $m11); //Y coordinate of the center
$r = sqrt($x0 ** 2 + $y0 ** 2 + $m14 / $m11); //Radius of the center
$G = 1000000 * $gamma * $V / ($B * $r * C);

//Check each particles
foreach(PARTICLES as $name => [$q, $m, $s]) {
    //Calculate the theorical value
    $g = abs($q) / $m;

    //We have found the particle
    if(abs($g - $G) / $g < 0.45) exit("$s " . round($r, -1));
}

echo "I just won the Nobel prize in physics !" . PHP_EOL;
