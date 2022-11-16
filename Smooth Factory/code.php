<?php

fscanf(STDIN, "%d", $V);

$values = [1];
$index = [[0, 2], [0, 3], [0, 5]]; //We use a different index for 2, 3 & 5

while(count($values) < $V) {
    //The next value for a winning game is the min among the three
    $value = min($values[$index[0][0]] * $index[0][1], $values[$index[1][0]] * $index[1][1], $values[$index[2][0]] * $index[2][1]);

    //When we use the value we increase the index, we might increase the index of more than one
    foreach($index as [&$i, $m]) {
        if($values[$i] * $m == $value) ++$i;
    }

    $values[] = $value;
}

echo array_sum($values) . PHP_EOL;
