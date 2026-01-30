<?php

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $points[] = [$x, $y];
}

//Find the center of mass
$area = 0;
$cx = 0;
$cy = 0;

for($i = 0; $i < $n; ++$i) {
    $temp = $points[$i][0] * $points[($i + 1) % $n][1] - $points[($i + 1) % $n][0] * $points[$i][1];

    $cx +=  ($points[$i][0] + $points[($i + 1) % $n][0]) * $temp;
    $cy +=  ($points[$i][1] + $points[($i + 1) % $n][1]) * $temp;

    $area += $temp;
}

$area /= 2;
$cx /= 6 * $area;
$cy /= 6 * $area;

$supportingSegments = 0;
$staticEquilibrium = 0;

for($i = 0; $i < $n; ++$i) {
    [$x1, $y1] = $points[$i]; // A

    for($j = $i + 1; $j < $n; ++$j) {
        [$x2, $y2] = $points[$j]; // B

        $prev = null;
    
        for($k = 0; $k < $n; ++$k) {
            if($i == $k || $j == $k) continue;

            [$x, $y] = $points[$k]; // C

            $sign = ($x2 - $x1) * ($y - $y1) - ($y2 - $y1) * ($x - $x1);

            // A, B & C are aligned
            if($sign == 0) {
                //If C lies between A & B we can continue, otherwise AB can't be a supporting segment
                $t = (($x - $x1) * ($x2 - $x1) + ($y - $y1) * ($y2 - $y1)) / (($x2 - $x1) ** 2 + ($y2 - $y1) ** 2);

                if($t < 0 || $t > 1) continue 2;
                else continue;
            }

            // Some part of the polygon would be below the ground
            if($prev !== null && ($prev < 0) != ($sign < 0)) continue 2;

            $prev = $sign;
        }

        $supportingSegments++;

        //We project the center of mass into the line and check if it falls into the supporting segment
        $t = (($cx - $x1) * ($x2 - $x1) + ($cy - $y1) * ($y2 - $y1)) / (($x2 - $x1) ** 2 + ($y2 - $y1) ** 2);

        if($t >= 0 && $t <= 1) $staticEquilibrium++;
    }
}

echo $supportingSegments . PHP_EOL;
echo $staticEquilibrium . PHP_EOL;
