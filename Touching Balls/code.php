<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d %d %d", $x, $y, $z, $r);

    $spheres[] = [$x, $y, $z, $r];
}

foreach($spheres as $i => [$x, $y, $z, $r]) {
    $newRadius = PHP_INT_MAX;

    foreach($spheres as $j => [$x2, $y2, $z2, $r2]) {
        if($i == $j) continue;
        
        $distance = sqrt(($x - $x2) ** 2 + ($y - $y2) ** 2 + ($z - $z2) ** 2);

        if(($max = $distance - $r2) < $newRadius) {

            $newRadius = $max;
        }
    }

    $spheres[$i][3] = $newRadius;
}

echo round(array_sum(array_map(function($v) { return $v ** 3; }, array_column($spheres, 3)))) . PHP_EOL;
