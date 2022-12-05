<?php

fscanf(STDIN, "%d", $x);
fscanf(STDIN, "%d", $n);

//Generate all the codes of size $size with the digits $digits
function generateCodes(array $digits, int $size): array {

    $codes = $digits;

    for($i = 1; $i < $size; ++$i) {
        $updatedCodes = [];

        foreach($codes as $code) {
            foreach($digits as $digit) {
                $updatedCodes[] = $code . $digit;
            }
        }

        $codes = $updatedCodes;
    }

    return $codes;
}

$codes = generateCodes(range(0, $x - 1), $n);

//Generate the de Bruijn graph (https://en.wikipedia.org/wiki/De_Bruijn_graph)
foreach($codes as $code) {
    $links[strval(substr($code, 0, -1))][] = strval(substr($code, 1));
}

function solve(string $position, array $stack): string {

    global $links;

    //We can still reach some nodes from this position, move to the first one
    if(count($links[$position])) {
        $stack[] = $position;
        return solve(array_shift($links[$position]), $stack);
    } //We can't move anywhere from this position
    else {
        //The last digit of the position is part of the Eulerian path
        $d = $position[-1];

        //If we have nowhere to backtrack, we are done
        if(empty($stack)) return $d;

        return solve(array_pop($stack), $stack) . $d;
    }
}

//The shortest sequence is the Eulerian path in the de Bruijn graph
//https://en.wikipedia.org/wiki/Eulerian_path
//We use the smallest index as starting point
echo str_repeat("0", $n - 2) . solve(array_key_first($links), []) . PHP_EOL;
