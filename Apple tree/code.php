<?php

fscanf(STDIN, "%d %d", $N, $index);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d %d %d", $x, $y, $z, $r);

    $apples[] = [$x, $y, $z, $r];
}

//The apple that's initially falling
$falling[] = $apples[$index];
unset($apples[$index]);

while(count($falling)) {
    [$x1, $y1, $z1, $r1] = array_pop($falling);

    foreach($apples as $i => [$x2, $y2, $z2, $r2]) {
        //Apple is above the one falling, it can't be hit
        if($z2 > $z1) continue;

        //Distance between the center of the apples when both apples are on the same Z level
        $distance = sqrt(pow($x1 - $x2, 2) + pow($y1 - $y2, 2));

        //The falling apple is hitting the other apple, it will also fall
        if($distance <= ($r1 + $r2)) {
            $falling[] = $apples[$i];
            unset($apples[$i]);
        }
    }
}

echo count($apples) . PHP_EOL;
