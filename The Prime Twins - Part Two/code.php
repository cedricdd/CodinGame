<?php

//https://en.wikipedia.org/wiki/Sieve_of_Eratosthenes
function sieveOfEratosthenes(int $limit): array {

    // Initialise the sieve array
    $sieve = array_fill(2, $limit - 1, 1);

    for($i = 2; $i < $limit; ++$i) {
        //This number is still in the sieve, remove all it's multiples
        if(isset($sieve[$i])) {
            for($j = $i * 2; $j < $limit; $j += $i) unset($sieve[$j]);
        }
    }

    return array_keys($sieve);
}

//Get all the twin primes up to $n
function twinPrimes(int $n): array {
    $primes = sieveOfEratosthenes($n);
    $count = count($primes);
    $twins = [];

    for($i = 1; $i < $count; ++$i) {
        if($primes[$i - 1] == $primes[$i] - 2) $twins[] = $primes[$i] - 1;
    }

    return $twins;
}

//Generate the alphabet with the key
function getAlphabet(int $key): array {
    $twins = twinPrimes(2000000);
    $countTwins = count($twins);
    $alphabet = [];
    $value = $key;
    $index = 0;

    foreach(range('A', 'Z') as $letter) {
        $alphabet[$letter] = strtoupper(dechex($key + $value));

        //Restart at the last index, the next one can only be bigger
        for($i = $index; $i < $countTwins; ++$i) {
            if($twins[$i] >= $key + $value + 2) break;
        }

        $value = $twins[$i];
        $index = $i + 1;
    }

    return $alphabet;
}

$operation = trim(fgets(STDIN));
fscanf(STDIN, "%d", $key);
$message = trim(fgets(STDIN));
$alphabet = getAlphabet($key);

//We are encoding
if($operation == "ENCODE") {
    foreach(str_split($message) as $c) {
        $output[] = $alphabet[$c];
    }

    echo implode("G", $output) . PHP_EOL;
} //We are decoding
else {
    $alphabet = array_flip($alphabet);
    $letters = preg_split("/G/", $message);

    // error_log(var_export($letters, true));

    echo implode("", array_map(function($letter) use ($alphabet) {
        return $alphabet[$letter];
    }, $letters)) . PHP_EOL;
}
