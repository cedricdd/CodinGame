<?php

fscanf(STDIN, "%d %d", $rows, $cols);
for ($y = 0; $y < $rows; ++$y) {
    for ($x = 0; $x < $cols; ++$x) {
        $image[$y][$x] = fscanf(STDIN, "%d %d %d");
    }
}

for ($y = 0; $y < $rows; ++$y) {
    for ($x = 0; $x < $cols; ++$x) {

        $values = [$image[$y][$x]];
        if($x > 0) $values[] = $image[$y][$x - 1];
        if($x < $cols - 1) $values[] = $image[$y][$x + 1];
        if($y > 0) $values[] = $image[$y - 1][$x];
        if($y < $rows - 1) $values[] = $image[$y + 1][$x];

        $count = count($values);

        echo floor(array_sum(array_column($values, 0)) / $count) . " " . 
             floor(array_sum(array_column($values, 1)) / $count) . " " . 
             floor(array_sum(array_column($values, 2)) / $count) . PHP_EOL;
    }
}
