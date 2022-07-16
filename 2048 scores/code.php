<?php

//Get the total score we got by creating the number $n
function getScore($n) {
    $score = 0;
    $power = 0;

    while($n >= 4) {
        $score += $n * pow(2, $power);
        $n = $n >> 1;
        $power++;
    }

    return $score;
}

$score = 0;
$moves = -2; //We start with at least 2 numbers

for ($i = 0; $i < 4; $i++) {
    foreach(explode(" ", fgets(STDIN)) as $value) {
        $score += getScore(intval($value));
        $moves += intval($value) / 2;
    }
}

fscanf(STDIN, "%d", $FOURS);

$score -= $FOURS * 4;
$moves -= $FOURS;

echo $score . "\n" . $moves . "\n";
?>
