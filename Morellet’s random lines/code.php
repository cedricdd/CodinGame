<?php

$lines = [];
$crossing = 0;

fscanf(STDIN, "%d %d %d %d", $xA, $yA, $xB, $yB);
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d %d", $a, $b, $c);

    if ($a != 0) $line = [1, $b/$a, $c/$a];
    else $line = [0, 1, $c/$b];

    if(in_array($line, $lines)) continue; //This is an identical line

    $lines[] = $line;

    $vA = $a * $xA + $b * $yA + $c; //Value using point A
    $vB = $a * $xB + $b * $yB + $c; //Value using point B

    if($vA == 0 || $vB == 0) exit("ON A LINE"); //If the point is on the line the value is 0

    if($vA * $vB < 0) ++$crossing; //If one value is positive and the other negative, the points are on a different side of the line 
}

echo (($crossing % 2 == 0) ? "YES" : "NO") . PHP_EOL;
