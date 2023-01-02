<?php

$history = [];

function solve(int $score, int $left): int {

    global $history;

    if(isset($history[$score][$left])) return $history[$score][$left];
    elseif($score == 50) return 1;
    elseif($score > 50 || $left == 0) return 0;

    $possibilities = 0;

    for($i = 1; $i <= 12; ++$i) {
        if($score + $i > 50) break; //We can stop, we have a score too big

        //We can make each numbers 2 ways except for 1
        $possibilities += solve($score + $i, $left - 1) * ($i == 1 ? 1 : 2);
    }

    return $history[$score][$left] = $possibilities;
}

fscanf(STDIN, "%d", $n);

echo solve($n, 4) . PHP_EOL;
