<?php

function getDivisors(int $n): array {

    $list = [];
     
    //Skip 1, we don't want a single row
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) $list[] = $n / $i;
    }

    return $list;
}

function checkPermutations(array $pieces, int $size, int $current): bool {

    //We used all the pieces it's a valid solution
    if(array_sum($pieces) == 0) return true;

    //The current row is full
    if($current == $size) $current = 0;

    foreach($pieces as $i => $count) {
        //We add a piece to the current
        if($pieces[$i] != 0 && $current + $i <= $size) {
            $pieces[$i]--;

            $result = checkPermutations($pieces, $size, $current + $i);

            if($result) return true;
            else $pieces[$i]++;
        }
    }

    return false;
}

fscanf(STDIN, "%d", $x1);
fscanf(STDIN, "%d", $x2);
fscanf(STDIN, "%d", $x3);

//We can just stack them vertically
if(($x1 && ($x2 + $x3) == 0) || ($x2 && ($x1 + $x3) == 0) || ($x3 && ($x1 + $x2) == 0)) die("POSSIBLE");

//Check all the row sizes that could make us use all the pieces
foreach(getDivisors($x1 + $x2 * 2 + $x3 * 3) as $size) {
    if(checkPermutations([1 => $x1, 2 => $x2, 3 => $x3], $size, 0)) die("POSSIBLE");
}

echo "NOT POSSIBLE" . PHP_EOL;
?>
