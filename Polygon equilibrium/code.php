<?php

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $points[] = [$x, $y];
}

$supportingSegments = 0;

for($i = 0; $i < $n; ++$i) {
    [$x1, $y1] = $points[$i];
    [$x2, $y2] = $points[($i + 1) % $n];

    $prev = null;
    
    for($j = 0; $j < $n; ++$j) {
        if($j == $i || $j == ($i + 1) % $n) continue;

        [$x, $y] = $points[$j];

        $sign = ($x2 - $x1) * ($y - $y1) - ($y2 - $y1) * ($x - $x1);

        error_log("$i " . ($i + 1) . " with $j => $sign");

        if($prev !== null && ($prev < 0) != ($sign < 0)) {
            error_log("here!!!");
            
            continue 2;
        }

        $prev = $sign;
    }

    $supportingSegments++;
}

echo $supportingSegments . PHP_EOL;
