<?php

//Minimax algorithm
function solve(array $values, int $depth, float $alpha, float $beta): int {
    global $explored, $D, $B;

    ++$explored;

    //We are on the deepest depth
    if($depth == $D) return array_pop($values);

    $value = ($depth % 2 == 0) ? -INF : INF;

    $length = count($values) / $B;

    for($i = 0; $i < $B; ++$i) {
        //We use the max value
        if($depth % 2 == 0) {
            $value = max($value, solve(array_slice($values, $i * $length, $length), $depth + 1, $alpha, $beta));

            if($value >= $beta) return $value; //Cutoff beta

            $alpha = max($alpha, $value);
        }
        //We use the min value
        else {
            $value = min($value, solve(array_slice($values, $i * $length, $length), $depth + 1, $alpha, $beta));

            if($alpha >= $value) return $value; //Cutoff alpha

            $beta = min($beta, $value);
        }
    }

    return $value;
}

fscanf(STDIN, "%d %d", $D, $B);
$values = explode(" ", trim(fgets(STDIN)));

$explored = 0;

echo solve($values, 0, -INF, INF) . " " . $explored . PHP_EOL;
