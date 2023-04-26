<?php

fscanf(STDIN, "%d %d %d", $R1, $G1, $B1);
fscanf(STDIN, "%d %d %d", $R2, $G2, $B2);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $combinations[] = fscanf(STDIN, "%d %d %d %d %d %d");
}

$goal = "$R2 $G2 $B2";

function solve(int $r, int $g, int $b) {
    static $history;
    global $combinations, $goal;

    $index = "$r $g $b";
    $history[$index] = 1;

    if($index == $goal) exit("YES");

    foreach($combinations as [$r1, $g1, $b1, $r2, $g2, $b2]) {
        //We have enough paint to do the transformation
        if($r1 <= $r && $g1 <= $g && $b1 <= $b) {
            //We can't have more than 30L of a single color
            if(($ru = $r - $r1 + $r2) > 30) continue;
            if(($gu = $g - $g1 + $g2) > 30) continue;
            if(($bu = $b - $b1 + $b2) > 30) continue;

            //Don't re-check a case we already checked
            if(!isset($history["$ru $gu $bu"])) solve($ru, $gu, $bu);
        }
    }
}

solve($R1, $G1, $B1);

echo "NO" . PHP_EOL;
