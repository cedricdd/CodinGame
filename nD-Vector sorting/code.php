<?php

fscanf(STDIN, "%d", $D);
fscanf(STDIN, "%d", $N);
$order = explode(" ", trim(fgets(STDIN)));

for ($i = 0; $i < $N; $i++) {
    $inputs[$i + 1] = explode(" ", trim(fgets(STDIN)));
}

uasort($inputs, function($a, $b) use($order) {
    //Find the dimension we need to compare these two vectors
    foreach($order as $i) {
        if($a[$i - 1] != $b[$i - 1]) break;
    }

    return $a[$i - 1] <=> $b[$i - 1];
});

echo implode(" ", array_keys($inputs)) . PHP_EOL;
