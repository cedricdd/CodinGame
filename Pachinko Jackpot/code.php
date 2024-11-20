<?php

$increments = [];

fscanf(STDIN, "%d", $height);
for ($i = 0; $i < $height; $i++) {
    $increments[$i] = str_split(trim(fgets(STDIN)));

    //Increment the score by the max of the two possibilities of reaching this place
    foreach($increments[$i] as $x => &$v) $v += max($increments[$i - 1][$x - 1] ?? 0, $increments[$i - 1][$x] ?? 0);

    unset($increments[$i - 1]); //Don't need that anymore
}

$jackpot = 0;

for ($i = 0; $i <= $height; $i++) {
    $prize = trim(fgets(STDIN));

    //Check the jackpot we can create with each prizes
    $jackpot = max($jackpot, max($increments[$height - 1][$i - 1] ?? 0, $increments[$height - 1][$i] ?? 0) * $prize);
}

echo $jackpot . PHP_EOL;
