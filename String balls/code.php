<?php

//Pre-compute the # of letters at a distance of X from Y
foreach(range("a", "z") as $indexLetter => $letter) {
    for($i = 0; $i < 26; ++$i) {
        if($i == 0) $alphabet[$letter][$i] = 1;
        else $alphabet[$letter][$i] = ($i <= $indexLetter) + ($i <= 25 - $indexLetter);
    }
}

$alphabet = array_map('array_filter', $alphabet); //We don't need the info with 0

fscanf(STDIN, "%d", $radius);

$dp[0] = 1;
    
foreach(str_split(trim(fgets(STDIN))) as $index => $c) {
    $dp2 = [];

    foreach($dp as $distance1 => $count1) {
        foreach($alphabet[$c] as $distance2 => $count2) {
            if(($distance = $distance1 + $distance2) <= $radius) {
                $dp2[$distance] = ($dp2[$distance] ?? 0) + ($count1 * $count2);
            }
        }
    }

    $dp = $dp2;
}

echo array_sum($dp) . PHP_EOL;
