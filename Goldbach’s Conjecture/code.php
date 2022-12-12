<?php

$start = microtime(1);

//https://en.wikipedia.org/wiki/Sieve_of_Atkin
function sieveOfAtkin(int $limit): array {

    // Initialise the sieve array with false values
    $sieve = array_fill(0, $limit + 1, 0);

    $primes = [2 => 1, 3 => 1, 5 => 1];

    /* Toggle sieve[n] if one of the following is true:
        A) 4x2+y2=n is odd and modulo-60 remainder is 1, 13, 17, 29, 37, 41, 49, or 53
        B) 3x2+y2=n is odd and modulo-60 remainder is 7, 19, 31, or 43
        C) 3x2-y2=n is odd and modulo-60 remainder is 11, 23, 47, or 59
    */

    $reminderA = array_flip([1, 13, 17, 29, 37, 41, 49, 53]);
    $reminderB = array_flip([7, 19, 31, 43]);
    $reminderC = array_flip([11, 23, 47, 59]);

    for ($x = 1; $x * $x <= $limit; $x++) {
        for ($y = 1; $y * $y <= $limit; $y++) {

            //A
            $n = (4 * $x * $x) + ($y * $y);
            $r = $n % 60;
            if ($n <= $limit && isset($reminderA[$n % 60])) $sieve[$n] ^= 1;

            //B
            $n = (3 * $x * $x) + ($y * $y);
            if ($n <= $limit && isset($reminderB[$n % 60])) $sieve[$n] ^= 1;

            //C
            $n = (3 * $x * $x) - ($y * $y);
            $r = $n % 60;
            if ($x > $y && $n <= $limit && isset($reminderC[$n % 60])) $sieve[$n] ^= 1;
        }
    }

    // Mark all multiples of squares as non-prime
    for ($r = 7; $r <= $limit; $r++) {
        //Take the next number in the sieve list still marked prime
        if ($sieve[$r]) {
            $primes[$r] = 1; //Include the number in the results list.

            //Square the number and mark all multiples of that square as non prime
            for ($i = $r * $r; $i <= $limit; $i += $r * $r) $sieve[$i] = 0;
        }
    }

    return $primes;
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $numbers[] = trim(fgets(STDIN));
}

$primes = sieveOfAtkin(max($numbers));

foreach($numbers as $number) {
    //Goldbach’s Conjecture is only for even numbers
    if($number & 1) echo "OOS" . PHP_EOL;
    else {
        $count = 0;
    
        //Check all primes up to the half of the number
        foreach($primes as $prime => $filler) {
            if($prime > $number >> 1) break;
            if(isset($primes[$number - $prime])) ++$count;
        }
    
        echo ($count > 0 ? $count : "OOS") . PHP_EOL;
    }
}

error_log(microtime(1) - $start);
