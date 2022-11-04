<?php

fscanf(STDIN, "%d %d", $N, $C);

for ($i = 0; $i < $C; $i++) {
    fscanf(STDIN, "%d %d", $XI, $YI);

    $clues[] = [sprintf("%0" . $N . "b", $XI), sprintf("%0" . $N . "b", $YI)];
}

function solve(array $positions, array $list, int $i): bool {
    global $clues, $N, $permutation;

    //We found the good permutation
    if($i == $N) {
        $permutation = $list;
        return true;
    }

    foreach($positions as $pos) {
        //Can $pos be used for index $i
        foreach($clues as [$xi, $yi]) {
            //Conflict with one of the clue
            if($yi[$i] != $xi[$pos]) continue 2;
        }

        unset($positions[$pos]);
        $list[$i] = $pos;

        //Continue testing by using $pos for index $i
        if(solve($positions, $list, $i + 1)) return true;

        $positions[$position] = $pos;
    }

    return false;
}

$permutation = [];
solve(range(0, $N - 1), [], 0);

//Our permutation is left to right so we calculate the output with 2^i in reverse
//All the 2^i only have 1 byte set to 1, we just need to get his position after the permutation
for($i = $N - 1; $i >= 0; --$i) {
    $output[] = pow(2, $N - 1 - array_search($i, $permutation));
}

echo implode(" ", $output) . PHP_EOL;
