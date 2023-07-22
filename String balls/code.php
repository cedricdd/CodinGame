<?php

//Pre-compute the # of letters at a distance of X from Y
foreach(range("a", "z") as $indexLetter => $letter) {
    for($i = 0; $i < 26; ++$i) {
        if($i == 0) $alphabet[$letter][$i] = 1;
        else $alphabet[$letter][$i] = ($i <= $indexLetter) + ($i <= 25 - $indexLetter);
    }
}

fscanf(STDIN, "%d", $radius);

$dp = array_fill(0, $radius + 1, 0);
$dp[0] = 1;

foreach(str_split(trim(fgets(STDIN))) as $index => $c) {

    for($i = $radius; $i > 0; --$i) {
        for($j = $i - 1; $j >= max(0, $i - 25); --$j) {
            $dp[$i] += $dp[$j] * $alphabet[$c][$i - $j];
        }
    }
}

echo array_sum($dp) . PHP_EOL;
