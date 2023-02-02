<?php

//https://en.wikipedia.org/wiki/Sieve_of_Eratosthenes
function sieveOfEratosthenes(int $limit): array {

    // Initialise the sieve array
    $sieve = array_fill(2, $limit, 1);

    for($i = 2; $i < $limit; ++$i) {
        //This number is still in the sieve, remove all it's multiples
        if(isset($sieve[$i])) {
            for($j = $i * 2; $j < $limit; $j += $i) unset($sieve[$j]);
        }
    }

    return array_keys($sieve);
}

//Get the prime factors of $number sorted in ascending order
function primeFactors(int $number): array {
    global $primes;

    $factors = [];
    $index = 0;

    while ($number >= 2) {
        if ($number % $primes[$index] == 0) {
            $factors[] = $primes[$index];
            $number /= $primes[$index];
        } else {
            //If we are out of primes to check, the number left is a prime, we are done
            if(++$index == count($primes)) {
                $factors[] = $number;
                break;
            }
        }
    }

    return $factors;
}

fscanf(STDIN, "%d %d %d", $width, $height, $number);

$y = 0;
$line = "";
$primes = sieveOfEratosthenes(ceil(sqrt(10**9)));

while($y < $height) {
    $numberWithFactors = $number . "=" . implode("*", primeFactors($number));

    if(!empty($line)) {
        //Not enough space left in current line to add the new number
        if(strlen($line) + strlen($numberWithFactors) + 1 > $width) {
            echo str_pad($line, $width, "-", STR_PAD_RIGHT) . PHP_EOL;
            ++$y;
            $line = "";
        } //We just add the number to the current line
        else {
            $line .= "," . $numberWithFactors;
            ++$number;
            continue;
        }
    }

    //Current line is empty & there's enough space for the number
    if(strlen($numberWithFactors) <= $width) {
        $line .= $numberWithFactors;
        ++$number;
    } //We can't add number anymore, finish the wallpaper with empty lines
    else {
        for($i = 0; $i < ($height - $y); ++$i) echo str_repeat("-", $width) . PHP_EOL;
        break;
    }
}
