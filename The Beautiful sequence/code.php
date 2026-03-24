<?php

fscanf(STDIN, "%d", $n);

$values = explode(' ', trim(fgets(STDIN)));

//Arrays to store boundaries
$left = array_fill(0, $n, -1);
$right = array_fill(0, $n, $n);

$stack = [];

//Compute left boundaries
for ($i = 0; $i < $n; $i++) {
    while (!empty($stack) && $values[end($stack)] >= $values[$i]) array_pop($stack);

    $left[$i] = empty($stack) ? -1 : end($stack);
    $stack[] = $i;
}

$stack = [];

//Compute right boundaries
for ($i = $n - 1; $i >= 0; $i--) {
    while (!empty($stack) && $values[end($stack)] >= $values[$i]) array_pop($stack);
    
    $right[$i] = empty($stack) ? $n : end($stack);
    $stack[] = $i;
}

$result = 0;

for ($i = 0; $i < $n; $i++) {
    $length = $right[$i] - $left[$i] - 1; //Length of the subsequence with the element $i being the smallest element
    $result = max($result, $values[$i] * $length);
}

echo $result . PHP_EOL;
