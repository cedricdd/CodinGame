<?php

$start = microtime(1);

$word1 = stream_get_line(STDIN, 256 + 1, "\n");
$word2 = stream_get_line(STDIN, 256 + 1, "\n");

$size1 = strlen($word1);
$size2 = strlen($word2);

$temp = array_fill(0, $size2, 0);
$dp = array_fill(0, $size1, $temp);

for($i = 0; $i <= $size1; ++$i) $dp[$i][0] = $i;
for($j = 0; $j <= $size2; ++$j) $dp[0][$j] = $j;

for($i = 1; $i <= $size1; ++$i) {
    for($j = 1; $j <= $size2; ++$j) {
        $dp[$i][$j] = min(
            1 + $dp[$i][$j - 1],
            1 + $dp[$i - 1][$j],
            $dp[$i - 1][$j - 1] + ($word1[$i - 1] == $word2[$j - 1] ? 0 : 1)
        );
    }
}

echo $dp[$size1][$size2] . PHP_EOL;

error_log(microtime(1) - $start);
