<?php

$alphabet = array_merge(['*'], range('A', 'Z'), [' ', '.']);

fscanf(STDIN, "%d %d", $e, $p);
fscanf(STDIN, "%d %d %d %d", $a, $b, $m, $x0);

if($a != 0 || $b != 0) $k = $x0;
else $k = 5;

$output = [];

foreach(str_split(trim(fgets(STDIN))) as $c) {
    $index = array_search($c, $alphabet);
    $output[] = bcpowmod($p, $k % 28 + 1, 29); //c1 = (p ^ k) mod 29
    $output[] = bcmod(bcmul($index, bcpow($p, bcmul($e, $k % 28 + 1))), 29); //c2 = (t * p ^ (ek)) mod 29

    if($a != 0 || $b != 0) $k = ($a * $k + $b) % $m;
}

echo implode(" ", $output) . PHP_EOL;

$decypher = explode(" ", trim(fgets(STDIN)));

$count = count($decypher);
$output = '';

for($i = 0; $i < $count; $i += 2) {
    $output .= $alphabet[bcmod(bcmul(bcpow($decypher[$i], bcsub(28, $e)), $decypher[$i + 1]), 29)]; //(c1 ^ −e * c2) mod 29
}

echo $output . PHP_EOL;
