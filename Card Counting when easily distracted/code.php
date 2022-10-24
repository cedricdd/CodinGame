<?php

$cards = [1 => 4, 2 => 4, 3 => 4, 4 => 4, 5 => 4, 6 => 4, 7 => 4, 8 => 4, 9 => 4, 10 => 16];
$values = ["A" => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, "T" => 10, "J" => 10, "Q" => 10, "K" => 10];

foreach(explode(".", trim(fgets(STDIN))) as $input) {
    if(preg_match("/^[2-9ATJQK]+$/", $input, $match)) {
        foreach(str_split($input) as $card) {
            $cards[$values[$card]]--; //Update the remaining cards
        }
    }
}

fscanf(STDIN, "%d", $bustThreshold);

echo round(array_sum(array_slice($cards, 0, $bustThreshold - 1)) / array_sum($cards) * 100) . "%" . PHP_EOL;
