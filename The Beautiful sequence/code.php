<?php

fscanf(STDIN, "%d", $n);

$values = explode(' ', trim(fgets(STDIN)));
$result = 0;

for($i = 0; $i < $n; ++$i) {
    $count = 1; 

    for($j = $i - 1; $j >= 0; --$j) {
        if($values[$j] >= $values[$i]) ++$count;
        else break;
    }
    for($j = $i + 1; $j < $n; ++$j) {
        if($values[$j] >= $values[$i]) ++$count;
        else break;
    }

    if($count * $values[$i] > $result) $result = $count * $values[$i];
}

echo $result . PHP_EOL;
