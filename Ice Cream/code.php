<?php

fscanf(STDIN, "%d %d", $N, $K);

$icecreams = array_map("intval", explode(" ", trim(fgets(STDIN))));

for($i = 0; $i < $N; ++$i) {

    $list = [];
    $size = 0;

    for($j = $i; $j < $N; ++$j) {
        $list[] = $icecreams[$j];
        sort($list);

        ++$size;

        if($size & 1) $median = $list[floor($size / 2)];
        else $median = round(($list[($size / 2) - 1] + $list[$size / 2]) / 2);

        if($median >= $icecreams[$i]) $medians[$i][$median] = 1;
    }
}

error_log(var_export($medians, true));

exit();

$min = min($icecreams);
$max = max($icecreams);

error_log("min $min, max $max");

foreach($averages[0] as $value => $filler) $dp[$value][$K] = [0, [-1 => $value]];

$start = microtime(1);

foreach($icecreams as $i => $icecream) {
    $dp2 = [];

    foreach($dp as $size => $list) {
        foreach($list as $left => [$meltage, $listActions]) {
            //We update the truck size
            if($left > 0 && $size != $icecream) {
                foreach($averages[$i] as $updatedSize => $filler) {
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

    if(1==1 && $i >= 0) {
        error_log("After $i -- $icecream");
        foreach($dp as $size => $list) {
            foreach($list as $left => [$meltage, $listActions]) {
                error_log("$size $left $meltage " . implode(" - ", $listActions));
            }
        }
    }

}



$minMeltage = INF;
$actions = [];

foreach($dp as $size => $list) {
    foreach($list as $left => [$meltage, $listActions]) {
        if($meltage < $minMeltage) {
            $minMeltage = $meltage;
            $actions = array_reverse($listActions);
        }
    }
}

error_log(var_export($actions, true));

error_log(microtime(1) - $start);

echo array_pop($actions) . PHP_EOL;

// game loop
while (TRUE) {
    fscanf(STDIN, "%d %d %d", $T, $U, $sTotal);

    echo array_pop($actions) . PHP_EOL;
}
