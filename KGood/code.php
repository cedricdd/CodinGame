<?php

$S = trim(fgets(STDIN));
fscanf(STDIN, "%d", $K);

$letters = [];
$max = 0;
$size = strlen($S);
$i = 0;

while($i < $size) {

    $letters = [$S[$i] => 1];
    $count = 1;
    $j = $i + 1;

    //Add characters as long as we don't go over the K different characters
    while($j < $size) {
        if(!isset($letters[$S[$j]])) {
            if($count < $K) {
                ++$count;
                $letters[$S[$j]] = 1;
            }
            else break;
        } else $letters[$S[$j]]++;

        ++$j;
    }

    //Check if we found a longest KGood
    if(($j - $i) > $max) $max = $j - $i;

    //Find the next starting position to check (the position where all the occurences of one character are removed from the previous kgood)
    $k = $i;

    while($k < $j) {
        //We found the next starting position
        if(--$letters[$S[$k]] == 0) {
            $i = $k + 1;

            //Not enough characters left to find a better solution
            if($size - $i < $max) break 2;
            else continue 2;
        }

        ++$k;
    }
}

echo $max . PHP_EOL;
