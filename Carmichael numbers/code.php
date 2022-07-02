<?php
//Check if a number n is a prime number
function primeCheck($n) {
    if ($n == 1) return 0;
     
    for ($i = 2; $i <= sqrt($n); ++$i){
        if ($n % $i == 0) return 0;
    }

    return 1;
}

//Get the prime factors of $n
function primeFactors($n) {
    $factors = [];
    $divisor = 2;

    while ($n >= 2) {
        if ($n % $divisor == 0) {
            $factors[$divisor] = 1;
            $n = $n / $divisor;
        } else {
            ++$divisor;
        }
    }
    return $factors;
}

fscanf(STDIN, "%d",$n);

$factors = primeFactors($n);

foreach($factors as $factor => $weight) {
    if(($n - 1) % ($factor - 1) != 0) exit("NO");
}

echo primeCheck($n) ? "NO" : "YES";
?>
