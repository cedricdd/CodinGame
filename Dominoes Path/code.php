<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $A, $B);

    $dominoes [] = [$A, $B];
}

function solve(string $left, string $right, array $dominoes): bool {
    
    if(count($dominoes) == 0) return true; //We have used all the domino, there's a full sequence

    foreach($dominoes as $i => [$a, $b]) {
        unset($dominoes[$i]); //Remove the domino from the list

        //We add this domino at the left by using A
        if($a == $left && solve($b, $right, $dominoes)) return true;

        //We add this domino at the left by using B
        if($b == $left && solve($a, $right, $dominoes)) return true;

        //We add this domino at the right by using A
        if($a == $right && solve($left, $b, $dominoes)) return true;

        //We add this domino at the right by using A
        if($b == $right && solve($left, $a, $dominoes)) return true;

        $dominoes[$i] = [$a, $b]; //The domino was not used
    }

    return false;
}

[$left, $right] = array_pop($dominoes); //We are searching for a full sequence, we can start with any dominoes
echo (solve($left, $right, $dominoes) ? "true" : "false") . PHP_EOL;
