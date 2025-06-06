<?php

const MOD = 1000000007;

$start = microtime(1);

fscanf(STDIN, "%d %d", $n, $k);
$inputs = array_map('intval', explode(" ", trim(fgets(STDIN))));

rsort($inputs);

$list = [0 => [0 => [0 => 1]]];

foreach($inputs as $i => $input) {
    $newList = [];

    foreach($list as $smashed => $list2) {
        foreach($list2 as $skipped => $list3) {
            foreach($list3 as $total => $count) {
                //We can choose not to smash it
                if($total + $input + $smashed <= $k) {
                    $newList[$smashed][$skipped + 1][$total + $input + $smashed] = ($newList[$smashed][$skipped + 1][$total + $input + $smashed] ?? 0) + $count;
                }

                //We can choose to skip it
                if($total + $skipped <= $k) {
                    $newList[$smashed + 1][$skipped][$total + $skipped] = ($newList[$smashed + 1][$skipped][$total + $skipped] ?? 0) + $count;
                }
            }
        }
    }

    $list = $newList;
}

$biggest = 0;
$ways = 0;

//Find the biggest size and how many ways we can reach it
foreach($list as $smashed => $list2) {
    foreach($list2 as $skipped => $list3) {
        foreach($list3 as $total => $count) {
            if($total > $biggest) {
                $biggest = $total;
                $ways = $count % MOD;
            } elseif($total == $biggest) {
                $ways += $count;
                $ways %= MOD;
            }
        }
    }
}

echo $biggest . " " . $ways . PHP_EOL;

error_log(microtime(1) - $start);
