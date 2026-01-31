<?php

function solve(int $i1, int $i2): int {
    global $word1, $word2, $size1, $size2;
    static $history = [];

    if(isset($history[$i1][$i2])) return $history[$i1][$i2];

    if($i1 == $size1) return $history[$i1][$i2] = $size2 - $i2;
    if($i2 == $size2) return $history[$i1][$i2] = $size1 - $i1;

    //Identical letters
    if($word1[$i1] == $word2[$i2]) return $history[$i1][$i2] = solve($i1 + 1, $i2 + 1);

    return $history[$i1][$i2] = 1 + min(
        solve($i1 + 1, $i2),     // delete
        solve($i1, $i2 + 1),     // insert
        solve($i1 + 1, $i2 + 1)  // replace
    );
}

$start = microtime(1);

$word1 = stream_get_line(STDIN, 256 + 1, "\n");
$word2 = stream_get_line(STDIN, 256 + 1, "\n");

$size1 = strlen($word1);
$size2 = strlen($word2);

echo solve(0, 0) . PHP_EOL;

error_log(microtime(1) - $start);
