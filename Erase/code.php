<?php

const MODULO = 998244353;

$start = microtime(1);

$A = trim(fgets(STDIN));
$lengthA = strlen($A);
$B = trim(fgets(STDIN));
$lengthB = strlen($B);

$dp = array_fill(0, $lengthB, array_fill(0, $lengthA, 0));

//Find how many ways we can create $B from $A with dynamic programming
for($i = 0; $i < $lengthA; ++$i) {
    for($j = 0; $j < min($i + 1, $lengthB); ++$j) {

        //Check if the $i th letter A can be the $j th letter of B
        $dp[$j][$i] = (($dp[$j][$i - 1] ?? 0) + (($A[$i] == $B[$j]) ? ($dp[$j - 1][$i - 1] ?? 1) : 0)) % MODULO;
    }
}

$solution = $dp[$lengthB - 1][$lengthA - 1];

//The number of transformations is identical for each solutions, it's the factorial of the # of letter we need to remove
for($i = 1; $i <= strlen($A) - strlen($B); ++$i) {
    $solution = ($solution * $i) % MODULO;
}

echo $solution . PHP_EOL;

error_log(microtime(1) - $start);
