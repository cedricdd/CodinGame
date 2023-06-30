<?php

fscanf(STDIN, "%d", $valueToReach);
fscanf(STDIN, "%d", $N);

$numbers = explode(" ", trim(fgets(STDIN)));
$values = explode(" ", trim(fgets(STDIN)));

asort($values); //Sort from smallest to highest value

$numberOfCoins = 0;

foreach($values as $index => $value) {
    //Using all the coins won't be enough
    if($numbers[$index] * $value < $valueToReach) {
        $valueToReach -= $numbers[$index] * $value;
        $numberOfCoins += $numbers[$index];
    } //We reached the minimum value
    else {
        $numberOfCoins += ceil($valueToReach / $value);
        $valueToReach = 0;
    }
}

if($valueToReach != 0) echo "-1" . PHP_EOL;
else echo $numberOfCoins . PHP_EOL;
