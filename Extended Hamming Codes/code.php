<?php

$bits = str_split(trim(fgets(STDIN)));

$a = array_sum($bits);
$b = $bits[1] + $bits[3] + $bits[5] + $bits[7] + $bits[9] + $bits[11] + $bits[13] + $bits[15]; //bdfhjlnp 
$c = $bits[2] + $bits[3] + $bits[6] + $bits[7] + $bits[10] + $bits[11] + $bits[14] + $bits[15]; //cdghklop 
$e = $bits[4] + $bits[5] + $bits[6] + $bits[7] + $bits[12] + $bits[13] + $bits[14] + $bits[15]; //efghmnop 
$i = $bits[8] + $bits[9] + $bits[10] + $bits[11] + $bits[12] + $bits[13] + $bits[14] + $bits[15]; //ijklmnop 

//a is even and another one is too => two errors
if(!($a & 1) && ($b & 1 || $c & 1 || $e & 1 || $i & 1)) echo "TWO ERRORS" . PHP_EOL;
else {
    if($b & 1 && $c & 1 && $e & 1 && $i & 1) $bits[15] ^= 1;
    elseif($b & 1 && $c & 1 && $e & 1) $bits[7] ^= 1;
    elseif($b & 1 && $c & 1 && $i & 1) $bits[11] ^= 1;
    elseif($b & 1 && $e & 1 && $i & 1) $bits[13] ^= 1;
    elseif($c & 1 && $e & 1 && $i & 1) $bits[14] ^= 1;
    elseif($b & 1 && $c & 1) $bits[3] ^= 1;
    elseif($b & 1 && $e & 1) $bits[5] ^= 1;
    elseif($c & 1 && $e & 1) $bits[6] ^= 1;
    elseif($b & 1 && $i & 1) $bits[9] ^= 1;
    elseif($c & 1 && $i & 1) $bits[10] ^= 1;
    elseif($e & 1 && $i & 1) $bits[12] ^= 1;
    elseif($b & 1) $bits[1] ^= 1;
    elseif($c & 1) $bits[2] ^= 1;
    elseif($e & 1) $bits[4] ^= 1;
    elseif($i & 1) $bits[8] ^= 1;
    elseif($a & 1) $bits[0] ^= 1;

    echo implode("", $bits) . PHP_EOL;
}
