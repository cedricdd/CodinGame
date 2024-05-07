<?php

//Return 1 is $n is a prime and it's first time we encounter it
function isNewPrime(int $n): int {
    static $history = [];

    if(isset($history[$n])) return 0;
    else $history[$n] = 1;

    if($n < 2) return 0;
    if($n == 2) return 1;
    if($n % 2 == 0) return 0;

    $maxCheck = sqrt($n); //Don't calculate it each time in the loop

    for($i = 3; $i <= $maxCheck; $i += 2) {
        if($n % $i == 0) return 0;
    }

    return 1;
}

fscanf(STDIN, "%d %d", $h, $w);

for ($y = 0; $y < $h; ++$y) {
    $grid[] = str_replace(" ", "", trim(fgets(STDIN)));
}

error_log(var_export($grid, true));

$primes = 0;

//Check across
for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        $number = "";
        $i = 0;

        do {
            $number .= $grid[$y][$x + $i];

            if(isNewPrime(intval($number))) ++$primes;

            ++$i;
        } while($x + $i < $w);
    }
}

//Check down
for($x = 0; $x < $w; ++$x) {
    for($y = 0; $y < $h; ++$y) {
        $number = "";
        $i = 0;

        do {
            $number .= $grid[$y + $i][$x];

            if(isNewPrime(intval($number))) ++$primes;

            ++$i;
        } while($y + $i < $h);
    }
}

echo $primes . PHP_EOL;
