<?php

//Generate all the unique combinaisons of the primes
function getUniqueCombinaisons($primes) {
    $count = count($primes);
    $members = pow(2, $count);
    $results = [];

    for($i = 1; $i < $members; ++$i) {
        $b = sprintf("%0" . $count . "b", $i); //We use the binary representation to generate the combinaison

        $combinaison = [];
        $numbers = 0;

        for($j = 0; $j < $count; ++$j) {
            if($b[$j] == '1') { //If the byte is 0 we skip the prime, with 1 we use it
                ++$numbers;
                $combinaison[] = $primes[$j];
            }
        }

        $results[$numbers][] = $combinaison;
    }

    return $results;
}

$ans = 0;

fscanf(STDIN, "%d %d", $n, $k);
$inputs = explode(" ", fgets(STDIN));
for ($i = 0; $i < $k; $i++) {
    $primes[] = intval($inputs[$i]);
}

$combinaisons = getUniqueCombinaisons($primes);

/*
 * The # of numbers divisible by each prime is $n/$prime
 * With more than one prime every product of 2 combinaisons of the primes is counted twice, we then have so substract them.
 * Substracting them we remove too many 3 combinaisons so we need to add them again and repeart the logic.
 * Foreach combinaisons of X primes, add if X is odd and substract if X is even.
 */
for($i = 1; $i <= $k; $i++) {
    foreach($combinaisons[$i] as $combinaison) {
        $ans += (($i & 1) ? 1 : -1) * intdiv($n, array_product($combinaison));
    }
}

echo $ans . PHP_EOL;
?>
