<?php

$start = microtime(1);

function factorial(int $num): int {
    static $history = [];

    if(isset($history[$num])) return $history[$num];

    $factorial = 1;

    for ($x=$num; $x>=1; $x--) {  
        $factorial *= $x;  
    } 

    return $history[$num] = $factorial;
}

//Permutations of multisets
function countPermutationUnique(array $letters): int {
    $numerator = factorial(count($letters));
    $denominator = 1;

    foreach(array_count_values($letters) as $value => $occurence) {
        $denominator *= factorial($occurence);
    }

    return $numerator / $denominator;
}

function solve(array $letters, array $word): int {
    if(count($letters) == 0) return 0;
    
    sort($letters);

    $letter = array_pop($word);
    $count = 0;

    //We only need to check each letter once, if we have the same letter multiple time it would produce duplicate 'words'
    foreach(array_unique($letters) as $i => $sortedLetter) {
        unset($letters[$i]); //We use that letter, it can't be used anymore

        if($letter == $sortedLetter) break; //We can stop all the other letters are after alphabetically

        $permutation = countPermutationUnique($letters); //How many unique permutation does that put before our word

        $count += $permutation;

        $letters[$i] = $sortedLetter; //Add the letter back to the pool of availability
    }

    return $count + solve($letters, $word);
}

$word = trim(fgets(STDIN));

echo (solve(str_split($word), str_split(strrev($word))) + 1) . PHP_EOL;

error_log(microtime(1) - $start);
