<?php

//Get the angle beetween 2 vectors
function getAngle(int $x1, int $y1, int $x2, int $y2): float  {
    return rad2deg(acos(($x1 * $x2 + $y1 * $y2) / (sqrt(pow($x1, 2) + pow($y1, 2)) * sqrt(pow($x2, 2) + pow($y2, 2)))));
}

//Get the directional vector
function getVector(int $x1, int $y1, int $x2, int $y2): array {
    return [$x2 - $x1, $y2 - $y1, sqrt(pow(abs($x1 - $x2), 2) + pow(abs($y1 - $y2), 2))];
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s %d %d %s %d %d %s %d %d", $A, $xA, $yA, $B, $xB, $yB, $C, $xC, $yC);

    [$xAB, $yAB, $lAB] = getVector($xA, $yA, $xB, $yB); //Get vertex info of AB
    [$xBC, $yBC, $lBC] = getVector($xB, $yB, $xC, $yC); //Get vertex info of BC
    [$xCA, $yCA, $lCA] = getVector($xC, $yC, $xA, $yA); //Get vertex info of CA

    if($lAB == $lBC) $answer = $A . $B . $C . " is an isosceles in $B ";
    elseif($lBC == $lCA) $answer = $A . $B . $C . " is an isosceles in $C ";
    elseif($lCA == $lAB) $answer = $A . $B . $C . " is an isosceles in $A ";
    else $answer = $A . $B . $C . " is a scalene ";

    $angle1 = getAngle($xAB, $yAB, -$xCA, -$yCA); //Get angle at point A
    $angle2 = getAngle(-$xAB, -$yAB, $xBC, $yBC); //Get angle at point B
    $angle3 = getAngle($xCA, $yCA, -$xBC, -$yBC); //Get angle at point C

    if($angle1 == 90) $answer .= "and a right in $A triangle.";
    elseif($angle2 == 90) $answer .= "and a right in $B triangle.";
    elseif($angle3 == 90) $answer .= "and a right in $C triangle.";
    elseif($angle1 > 90) $answer .= "and an obtuse in $A (" . round($angle1) . "°) triangle.";
    elseif($angle2 > 90) $answer .= "and an obtuse in $B (" . round($angle2) . "°) triangle.";
    elseif($angle3 > 90) $answer .= "and an obtuse in $C (" . round($angle3) . "°) triangle.";
    else $answer .= "and an acute triangle.";

    echo $answer . PHP_EOL;
}
