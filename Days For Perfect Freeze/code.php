<?php

fscanf(STDIN, "%d", $totalDays);
fscanf(STDIN, "%f", $probabilityStayF);
fscanf(STDIN, "%f", $probabilityStayS);

$probability = 0.5; //We start with 50/50
$result = 0.0;

for($i = 0; $i < $totalDays; ++$i) {
    $result += $probability;

    //The probability it stays frozen + the probability it becomes frozen
    $probability = ($probability * $probabilityStayF) + ((1 - $probability) * (1 - $probabilityStayS));
}

echo floor($result) . PHP_EOL;
