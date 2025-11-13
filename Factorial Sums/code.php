<?php

//1 ≤ n ≤ 10000
const FACTORIAL = [7 => 5040,6 => 720,5 => 120,4 => 24,3 => 6,2 => 2,1 => 1];

fscanf(STDIN, "%d", $N);
$result = [];

while($N) {
    foreach(FACTORIAL as $i => $f) {
        if($f <= $N) {
            $result[] = "$i!";
            $N -= $f;
            break;
        }
    }
}

echo implode(" + ", $result);
