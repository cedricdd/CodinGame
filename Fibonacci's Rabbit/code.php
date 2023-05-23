<?php

fscanf(STDIN, "%d %d", $pairs[0], $N);
fscanf(STDIN, "%d %d", $a, $b);

for($i = 1; $i <= $N; ++$i) {
    $pairs[$i] = 0;
    for($j = $i - $b; $j <= $i - $a; ++$j) 
        $pairs[$i] = bcadd($pairs[$i], ($pairs[$j] ?? 0));
}

echo $pairs[$N] . PHP_EOL;
