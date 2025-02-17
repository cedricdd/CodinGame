<?php

/**
 * There are 5 fermat primes (3, 5, 17, 257 & 65537), here's the list of all the possible products of fermat primes (from 1 to 5) 
 * in addition to the number 1 if we use no fermat prime and just the power of 2
 */
const FERMAT = [
    0 => 1,
    1 => 3,
    2 => 5,
    3 => 15,
    4 => 17,
    5 => 51,
    6 => 85,
    7 => 255,
    8 => 257,
    9 => 771,
    10 => 1285,
    11 => 3855,
    12 => 4369,
    13 => 13107,
    14 => 21845,
    15 => 65535,
    16 => 65537,
    17 => 196611,
    18 => 327685,
    19 => 983055,
    20 => 1114129,
    21 => 3342387,
    22 => 5570645,
    23 => 16711935,
    24 => 16843009,
    25 => 50529027,
    26 => 84215045,
    27 => 252645135,
    28 => 286331153,
    29 => 858993459,
    30 => 1431655765,
    31 => 4294967295
];

fscanf(STDIN, "%d %d", $a, $b);

$count = 0;
$power = 1;

//Until the power of 2 is bigger than the end of the range
while($power < $b) {
    foreach(FERMAT as $fermat) {
        $number = $power * $fermat;

        if($number > $b) break;
        if($number >= $a) ++$count;
    }

    $power <<= 1;
}

echo $count . PHP_EOL;
