<?php

$range = [1, 100];

fscanf(STDIN, "%d", $R);
for ($i = 0; $i < $R; $i++) {
    preg_match("/([0-9]+) (.*)/", trim(fgets(STDIN)), $matches);

    [, $value, $reply] = $matches;

    if($reply == "too high") {
        if($value <= $range[0]) die("Alice cheated in round " . ($i + 1));
        else $range[1] = min($range[1], $value - 1);
    } elseif($reply == "too low") {
        if($value >= $range[1]) die("Alice cheated in round " . ($i + 1));
        else $range[0] = max($range[0], $value + 1);
    } elseif($value < $range[0] || $value > $range[1]) {
        die("Alice cheated in round " . ($i + 1));
    }

}

echo "No evidence of cheating" . PHP_EOL;
