<?php

const OUTCOME = [
    "Rock" => ["Rock" => 0, "Paper" => -1, "Scissors" => 1],
    "Paper" => ["Rock" => 1, "Paper" => 0, "Scissors" => -1],
    "Scissors" => ["Rock" => -1, "Paper" => 1, "Scissors" => 0],
];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $players[] = trim(fgets(STDIN));
}

$bestMove = [0, 0, ""];

for($i = 0; $i < $n; ++$i) {
    $winned = 0;
    $move = array_search(-1, OUTCOME[$players[$i]]); //You must win the first game

    for($j = 0; $j < $n; ++$j) {
        if(($result = OUTCOME[$move][$players[($i + $j) % $n]]) == -1) continue 2; //We continue until a game is lost

        if($winned += $result >= $bestMove[0]) $bestMove = [$winned, $move, $i];
    }
}

echo implode("\n", array_slice($bestMove, 1)) . PHP_EOL;
