<?php

fscanf(STDIN, "%d", $N);

$inputs = explode(" ", fgets(STDIN));

$left = array_fill(0, $N, PHP_INT_MIN);
$right = array_fill(0, $N, PHP_INT_MIN);

$min = $inputs[0];

//Get the difference for each positions with the smallest value on it's left
for($index = 1; $index < $N; ++$index) {
    if($inputs[$index] > $min) $left[$index] = $inputs[$index] - $min;
    else $min = $inputs[$index];
}

$min = $inputs[$N - 1];

//Get the difference for each positions with the smallest value on it's right
for($index = $N - 2; $index >= 0; --$index) {
    if($inputs[$index] > $min) $right[$index] = $inputs[$index] - $min;
    else $min = $inputs[$index];
}

$result = 0;

//The difficult leap is the sum of the difference on the left & right
for($i = 0; $i < $N; ++$i) {
    if(($t = $left[$i] + $right[$i]) > $result) $result = $t;
}

echo $result . PHP_EOL;
