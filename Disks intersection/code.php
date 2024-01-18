<?php

fscanf(STDIN, "%d %d %d", $x1, $y1, $r1);
fscanf(STDIN, "%d %d %d", $x2, $y2, $r2);

$distance = sqrt(($x1 - $x2) ** 2 + ($y1 - $y2) ** 2);

//No intersection
if($distance >= $r1 + $r2) echo "0.00" . PHP_EOL;
else {
    //Circle 2 is fully inside Circle 1
    if($r1 >= $r2 && $distance + $r2 <= $r1) echo number_format(pi() * ($r2 ** 2), 2, ".", "");
    //Circle 1 is fully inside Circle 2
    elseif($r2 >= $r1 && $distance + $r1 <= $r2) echo number_format(pi() * ($r1 ** 2), 2, ".", "");

    else {
        /*
        * https://dassencio.org/102
        * d1 = r1² - r2² + d² / 2d
        * d2 = d - d1
        * 
        * intersection = r1² cos-1(d1/r1) - d1 √(r1² - d1²) + r2² cos-1(d2/r2) - d2√(r2² - d2²) 
        */
        $d1 = (($r1 ** 2) - ($r2 ** 2) + ($distance ** 2)) / (2 * $distance);
        $d2 = $distance - $d1;

        $sum = ($r1 ** 2) * acos($d1 / $r1) - $d1 * sqrt(($r1 ** 2) - ($d1 ** 2)) + ($r2 ** 2) * acos($d2 / $r2) - $d2 * sqrt(($r2 ** 2) - ($d2 ** 2));

        echo number_format($sum, 2, ".", "");
    }
}
