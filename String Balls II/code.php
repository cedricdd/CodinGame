<?php

const MOD = 1000000007;

$start = microtime(1);

//Pre-compute the # of letters at a distance of X from Y
foreach(range("a", "z") as $indexLetter => $letter) {
    for($i = 0; $i < 26; ++$i) {
        if($i == 0) $alphabet[$letter][$i] = 1;
        else $alphabet[$letter][$i] = ($i <= $indexLetter) + ($i <= 25 - $indexLetter);
    }

    $max[$letter] = array_key_last(array_filter($alphabet[$letter]));
}

$alphabet = array_map('array_filter', $alphabet);

fscanf(STDIN, "%d", $radius);
$center = str_split(trim(fgets(STDIN)));

$maxRadius = 0;
foreach($center as $letter) $maxRadius += $max[$letter];

$totalString = 1;
for($i = count($center); $i > 0; --$i) {
    $totalString *= 26;
    $totalString %= MOD;
}

error_log("Total String is $totalString");
error_log("Max Radius is $maxRadius");
error_log("Radius: $radius - Reverse: " . ($maxRadius - $radius));

if($maxRadius <= $radius) exit("$totalString");

//We are counting how many are inside the ball, the limit will be $radius
if($radius < ($maxRadius - $radius)) {
    $dp[0] = 1;
    
    foreach($center as $index => $c) {
        $dp2 = [];

        foreach($dp as $distance1 => $count1) {
            foreach($alphabet[$c] as $distance2 => $count2) {
                //We check if the total distance of the current string is within the radius.
                if(($distance = $distance1 + $distance2) <= $radius) {
                    $dp2[$distance] = (($dp2[$distance] ?? 0) + ($count1 * $count2) % MOD);
                }
            }
        }

        $dp = $dp2;
    }

    echo (array_sum($dp) % MOD) . PHP_EOL;
} //We are counting how many are outside the ball, the limit will be ($maxRadius - $radius)
else {
    $limit = ($maxRadius - $radius);
    $dp[0] = 1;
    
    foreach($center as $index => $c) {
        $dp2 = [];

        foreach($dp as $distance1 => $count1) {
            foreach($alphabet[$c] as $distance2 => $count2) {
                /**
                 * We check if the total distance of the current string is outside the radius.
                 * Instead of using the distance from the center we use the distance from the 'opposite' of the center, the string with the biggest distance from the center.
                 * Example with center abcxyz we will use zzzaaa for each letters from the center, the opposite letter will be 'a' or 'z'
                 */
                if(($distance = $distance1 + ($max[$c] - $distance2)) < $limit) {
                    $dp2[$distance] = (($dp2[$distance] ?? 0) + ($count1 * $count2) % MOD);
                }
            }
        }

        $dp = $dp2;
    }

    echo (($totalString - (array_sum($dp) % MOD) + MOD) % MOD) . PHP_EOL;
}

error_log(microtime(1) - $start);
