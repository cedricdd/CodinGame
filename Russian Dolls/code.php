<?php

function solve(array $numbers, int $size): int {
    $total = 0;
    $count = count($numbers);

    if($count & 1) return -1; //We can't have an odd number of numbers
    if($count == 0) return 1; //We found a solid doll

    for($indexS = 0; $indexS < $count;) {
        //The start needs to be a negative number
        if($numbers[$indexS] >= 0) return -1;

        //Search for the end of the doll
        for($indexE = $indexS + 1; $indexE < $count; ++$indexE) {
            //Found the end of the doll
            if($numbers[$indexE] == $numbers[$indexS] * -1) {
                $return = solve(array_slice($numbers, $indexS + 1, $indexE - $indexS - 1), $numbers[$indexE]);

                if($return == -1) return -1; //Any invalid anywhere makes the whole design invalid
                else $total += $return;

                $size -= $numbers[$indexE];

                $indexS = $indexE + 1;
                continue 2;
            }
        }

        return -1; //We could not find the end of the doll
    }

    if($size <= 0) return -1; //Check the size, make sure nested doll are not too big
    else return $total;
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $input = trim(fgets(STDIN));

    //Search for bad characters
    if(preg_match("/[^0-9 \-]/", $input)) {
        echo "-1" . PHP_EOL;
        continue;
    }

    $input = explode(" ", $input);
    $position = array_search($input[0] * - 1, $input);

    //Invalid mother doll
    if(intval($input[0]) >= 0 || $position !== array_key_last($input)) {
        echo "-1" . PHP_EOL;
        continue;
    }

    echo solve(array_slice($input, 1, -1), $input[0] * -1) . PHP_EOL;
}
