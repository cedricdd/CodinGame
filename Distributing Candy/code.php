<?php

fscanf(STDIN, "%d %d", $n, $m);
$bags = array_map('intval', explode(" ", trim(fgets(STDIN))));

sort($bags);

$answer = INF;

//We just check the difference of all the $m intervals
for($i = 0; $i <= $n - $m; ++$i) {
    $answer = min($answer, $bags[$i + $m - 1] - $bags[$i]);
}

echo $answer . PHP_EOL;
