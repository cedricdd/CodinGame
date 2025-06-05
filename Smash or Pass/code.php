<?php

fscanf(STDIN, "%d %d", $n, $k);
$inputs = explode(" ", trim(fgets(STDIN)));

rsort($inputs);

error_log(var_export($inputs, 1));

$list = [[0, 0, 0]];

foreach($inputs as $input) {
    error_log("working on $input");
    $newList = [];

    foreach($list as [$smashed, $total, $left]) {
        //We can choose not to smash it
        if($total + $input <= $k) {
            $newList[] = [$smashed, $total + $input, $left + 1];
        }

        //Invalid we can't do anything with it
        if($total + $left <= $k) {
            $newList[] = [$smashed + 1, $total + $left, $left];
        }
    }

    $list = $newList;
}

error_log(var_export($list, 1));
