<?php

//Check if a number is prime
function isPrime(int $number): bool {
    if ($number == 1) return false;
     
    for ($i = 2; $i <= sqrt($number); $i++){
        if ($number % $i == 0) return false;
    }

    return true;
}

fscanf(STDIN, "%d", $N);

$outputs = array_fill(0, $N, array_fill(0, $N, " "));

$x = $N >> 1; //Starting x position
$y = $N >> 1; //Starting y position
$c = 1; //counter
$s = 1; //size of the segment to add
$direction = 0; //0 right, 1 up, 2 left, 3 down

//Construct the square spiral
for ($i = 1; $i < $N; $i++) {
    //The last time we need to add 3 segments, 2 othewise
    for($j = 0; $j < (($i != $N - 1) ? 2 : 3); ++$j) {
        for($k = 0; $k < $s; ++$k) {
            //Add a # if the counter is a prime
            if(isPrime($c++)) $outputs[$y][$x] = "#";

            //Update x, y based on direction
            switch($direction) {
                case 0: ++$x; break;
                case 1: --$y; break;
                case 2: --$x; break;
                case 3: ++$y; break;
            }
        }
        //At the end of each segment the direction changes
        $direction = ($direction + 1) % 4;
    }
    //The size of segments is increasing
    ++$s;
}

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $outputs));
?>
