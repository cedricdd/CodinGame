<?php

$digits = range(1, 9);
$turn = 1;

fscanf(STDIN, "%d", $s);
fscanf(STDIN, "%d", $p);

//Generate the list of all sums & multiplications that can be made with the 9 digits
foreach($digits as $digit1) {
    foreach($digits as $digit2) {
        if($digit2 < $digit1) continue; 

        $possibleSum[$digit1 + $digit2][$digit1 . "," . $digit2] = 1;
        $possibleMul[$digit1 * $digit2][$digit1 . "," . $digit2] = 1;
    }
}

$impossibleBurt = [];
$impossibleSarah = [];

while(true) {
    
    foreach($possibleSum as $sum => &$list) {
        //Burt can remove all the pair that were the unique solution for Sarah
        foreach($impossibleBurt as $pair) unset($list[$pair]);

        if(count($list) > 1) continue;

        //Burt knows for sure what the 2 digits are
        if($s == $sum) exit("(" . array_key_first($list) . ") BURT " . $turn);

        //It's an unique solution, Sarah will know it can't the right one
        if(count($list) != 0) $impossibleSarah[] = array_key_first($list);

        unset($possibleSum[$sum]);
    }

    $impossibleBurt = [];

    foreach($possibleMul as $mul => &$list) {
         //Sarah can remove all the pair that were the unique solution for Burt
        foreach($impossibleSarah as $pair) unset($list[$pair]);

        if(count($list) > 1) continue;

        //Sarah knows for sure what the 2 digits are
        if($p == $mul) exit("(" . array_key_first($list) . ") SARAH " . $turn);

        //It's an unique solution, Burt will know it can't the right one
        if(count($list) != 0) $impossibleBurt[] = array_key_first($list);

        unset($possibleMul[$mul]);
    } 

    //Neither Burt nor Sarah can eliminate more pairs, the two digits can't be guessed
    if(count($impossibleBurt) == 0 && count($impossibleSarah) == 0) exit("IMPOSSIBLE");

    $impossibleSarah = [];

    ++$turn;
}
