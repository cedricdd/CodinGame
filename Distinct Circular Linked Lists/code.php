<?php

const MODULO = "1000000007";

function GCD(int $a, int $b): int {
    if ($b === 0) return $a;
    
    return GCD($b, $a % $b);
}

function factorial(int $n): string {
    $result = '1'; 

    for ($i = 2; $i <= $n; $i++) {
        $result = bcmul($result, $i);  
    }

    return $result;
}

fscanf(STDIN, "%d", $n);

$nodes = [];

for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d", $node);

    $nodes[$node] = ($nodes[$node] ?? 0) + 1;
}

//All the nodes have the same value
if(count($nodes) == 1) exit("1");

$min = min($nodes);

/**
 * Burnside's lemma
 * https://en.wikipedia.org/wiki/Burnside%27s_lemma
 */


//Rotation k=0 (identity)
$repeatValue = '1';

foreach($nodes as $node => $occ) {
    $repeatValue = bcmul(factorial($occ), $repeatValue);
}

$sum = bcdiv(factorial($n), $repeatValue);
$history = [];

for($k = 1; $k < $n; ++$k) {
    $gcd = GCD($n, $k);

    if(isset($history[$gcd])) {
        $sum = bcadd($sum, $history[$gcd]);
        continue;
    }

    $cycle = $n / $gcd;

    //It's possbile we have a rotation
    if($min >= $cycle) {
        $tmp = '1';

        foreach($nodes as $node => $occ) {
            //We can't properly split the node for this rotation
            if(($occ % $cycle) != 0) {
                $history[$gcd] = 0;
                continue 2;
            }

            $tmp = bcmul($tmp, factorial($occ / $cycle));
        }
        
        $history[$gcd] = bcdiv(factorial($gcd), $tmp);
        $sum = bcadd($sum, $history[$gcd]);
    } else $history[$gcd] = 0;
}

echo bcmod(bcdiv($sum, (string)$n), MODULO) . PHP_EOL;
