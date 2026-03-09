<?php

//https://en.wikipedia.org/wiki/Josephus_problem
function josephus($n, $start, $dir) {
    $p = pow(2, floor(log($n, 2))); // largest power of 2 ≤ n

    $j = ($n - $p) * 2 + $start; 

    //counter-clockwise, we want the mirror position from the starting point
    if($dir == "RIGHT") $j = $start - abs($j - $start);

    return ($j + $n) % $n; //Make sure we are in the valid range
}

fscanf(STDIN, "%d %d", $N, $S);
$D = stream_get_line(STDIN, 20 + 1, "\n");

echo josephus($N, $S, $D) . PHP_EOL;
