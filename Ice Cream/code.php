<?php

fscanf(STDIN, "%d %d", $N, $K);

$icecreams = array_map("intval", explode(" ", trim(fgets(STDIN))));

//Get the truck sizes we can use for each turns
for($i = 0; $i < $N; ++$i) {

    $max = 0;

    for($j = $i; $j < $N; ++$j) {

        if($icecreams[$j] > $max) {
            $max = $icecreams[$j];
            $possibilities[$i][$max] = 1;
        }
    }
}

//Generate the starting truck sizes
foreach($possibilities[0] as $size => $filler) $dp[$size][$K] = [0, [-1 => $size]];

foreach($icecreams as $i => $icecream) {
    $dp2 = [];

    foreach($dp as $size => $list) {
        foreach($list as $left => [$meltage, $listActions]) {
            //We update the truck size
            if($i > 0 && $left > 0 && $size != $icecream) {
                foreach($possibilities[$i] as $updatedSize => $filler) {
                    if($updatedSize == $size) continue;

                    $meltageUpdated = $meltage + $updatedSize - $icecream;

                    //We insert it if it doesn't already exist or replace if meltage is lower
                    if(!isset($dp2[$updatedSize][$left - 1]) || $dp2[$updatedSize][$left - 1][0] > $meltageUpdated) {
                        $dp2[$updatedSize][$left - 1] = [$meltageUpdated, $listActions + [$i => "Change $updatedSize"]];
                    } 
                }


            }

            //We keep the current truck size
            if($size >= $icecream) {
                $meltageUpdated = $meltage + $size - $icecream;

                //We insert it if it doesn't already exist or replace if meltage is lower
                if(!isset($dp2[$size][$left]) || $dp2[$size][$left][0] > $meltageUpdated) {
                    $dp2[$size][$left] = [$meltageUpdated, $listActions + [$i => "Keep"]];
                } 
            }
        }
    }

    $dp = $dp2;
}

$minMeltage = INF;
$actions = [];

//Find the best solution
foreach($dp as $size => $list) {
    foreach($list as $left => [$meltage, $listActions]) {
        if($meltage < $minMeltage) {
            $minMeltage = $meltage;
            $actions = array_reverse($listActions);
        }
    }
}

echo array_pop($actions) . PHP_EOL;

while (TRUE) {
    fscanf(STDIN, "%d %d %d", $T, $U, $sTotal);

    echo array_pop($actions) . PHP_EOL;
}
