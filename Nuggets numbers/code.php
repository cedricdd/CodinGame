<?php

function gcd(int $a, int $b): int {
    while ($b != 0) {
        $tmp = $b;
        $b = $a % $b;
        $a = $tmp;
    }

    return abs($a);
}

$boxes = [];

fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d", $boxes[]);
}

$gcd = array_reduce($boxes, function($a, $b) {
    error_log("$a $b");
    return gcd($a,$b);
}, $boxes[0]);

//If the GCD of all the values isn't 1 there's an infinity amount of impossible amount
if($gcd != 1) exit('-1');

sort($boxes);

$limit = 100000; //Safe for small inputs like here
$reachable = array_fill(0, $limit, false);
$reachable[0] = true;
$consecutive = 0;
$largestImpossible = 0;

for ($i = 1; $i <= $limit; $i++) {
    //Check if we can add any boxes to a previously reached value to reach the current value
    foreach ($boxes as $b) {
        if ($i >= $b && $reachable[$i - $b]) {
            $reachable[$i] = true;
            break;
        }
    }

    if ($reachable[$i]) {
        $consecutive++;

        //We have found enough consecute reachable numbers to consider that everything after is reachable
        if ($consecutive == $boxes[0]) exit("$largestImpossible");
    } else {
        $largestImpossible = $i;
        $consecutive = 0;
    }
}

echo "-1" . PHP_EOL;
