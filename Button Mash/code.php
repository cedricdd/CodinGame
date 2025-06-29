<?php

fscanf(STDIN, "%d", $n);

$history = [0 => 1, 1 => 1];
$count = 1;
$values = [1];

while(true) {
    if(isset($history[$n])) exit("$count");

    $newValues = [];

    foreach($values as $value) {
        foreach ([$value + 1, $value - 1, $value * 2] as $value2) {
            if($value2 >= 0 && !isset($history[$value2])) {
                $history[$value2] = 1;
                $newValues[] = $value2;
            }
        }
    }

    $values = $newValues;
    ++$count;
}
