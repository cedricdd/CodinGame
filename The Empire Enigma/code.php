<?php

function RNG(int $value): int {
    return (7562100 * $value + 907598307) % 7140;
}

/*
 * We can see that there is a periodicity in the seed of only 17, seed 1 gets you the same results as seed 18, seed 2 = seed 19, ...
 * We can see that there is a periodicity in the RNG of only 16, RNG 1 = RNG 17, RNG 2 = RNG 18 unless for the seed 15 where all RNG are identical
for($i = 1; $i <= 100; ++$i) {
    error_log("Seed $i");

    $random = $i;

    for($j = 1; $j <= 100; ++$j) {
        $random = RNG($random);

        error_log("RNG $j $random");
    }
}
*/

function decodeCharacter(int $encoded, int $random): string {
    return chr(bindec(substr(sprintf("%08b", $encoded ^ $random), -8)));
}

fscanf(STDIN, "%d", $offset);
$index = $offset % 17; //The index of the first RNG used to encode

fscanf(STDIN, "%d", $length);
for ($i = 0; $i < $length; $i++) {
    $encoded[] = trim(fgets(STDIN));
}

//We have to test all the seeds to find the one that was used
for($seed = 1; $seed <= 18; ++$seed) {

    for($i = 0; $i < 17; ++$i) {
        $randoms[$i] = RNG($randoms[$i - 1] ?? $seed);
    }

    //We know that the first character is "@";
    if(decodeCharacter($encoded[0], $randoms[$index]) != "@") continue;

    break;
}

//We have found the seed, we can now decode the message
for($i = 1; $i < $length; ++$i) {
    echo decodeCharacter($encoded[$i], $randoms[($index = ($index + 1) % 16)]);
}
