<?php

//Get the directional vector
function getVector(int $x1, int $y1, int $x2, int $y2): array {
    return [$x2 - $x1, $y2 - $y1, sqrt(pow(abs($x1 - $x2), 2) + pow(abs($y1 - $y2), 2))];
}

//Get the angle beetween 2 vectors
function getAngle(int $x1, int $y1, int $x2, int $y2): float  {
    return rad2deg(acos(($x1 * $x2 + $y1 * $y2) / (sqrt(pow($x1, 2) + pow($y1, 2)) * sqrt(pow($x2, 2) + pow($y2, 2)))));
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++){
    fscanf(STDIN, "%s %d %d %s %d %d %s %d %d %s %d %d", $A, $xA, $yA, $B, $xB, $yB, $C, $xC, $yC, $D, $xD, $yD);

    [$xAB, $yAB, $lAB] = getVector($xA, $yA, $xB, $yB);
    [$xBC, $yBC, $lBC] = getVector($xB, $yB, $xC, $yC);
    [$xCD, $yCD, $lCD] = getVector($xC, $yC, $xD, $yD);
    [$xDA, $yDA, $lDA] = getVector($xD, $yD, $xA, $yA);

    $angle1 = getAngle($xAB, $yAB, $xBC, $yBC);
    $angle2 = getAngle($xBC, $yBC, $xCD, $yCD);
    $angle3 = getAngle($xCD, $yCD, $xDA, $yDA);
    $angle4 = getAngle($xDA, $yDA, $xAB, $yAB);

    $parallel = $angle1 == $angle3 && $angle2 == $angle4;
    $rhombus = $lAB == $lBC && $lBC == $lCD && $lCD == $lDA;

    if($rhombus && $parallel && $angle1 == 90) echo "$A$B$C$D is a square." . PHP_EOL;
    elseif($parallel && $angle1 == 90) echo "$A$B$C$D is a rectangle." . PHP_EOL;
    elseif($rhombus) echo "$A$B$C$D is a rhombus." . PHP_EOL;
    elseif($parallel) echo "$A$B$C$D is a parallelogram." . PHP_EOL;
    else echo "$A$B$C$D is a quadrilateral." . PHP_EOL;
}
