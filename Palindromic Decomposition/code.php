<?php

//We want all the positions we can reach starting at $start when consuming a palindrome
function findPosition(int $start, int $size, array $palindromes): array {
    $results = [];

    /**
     * For each position x we need to check 2 values in $palindromes
     * (2 * x + 1) would be a palindrome of even size centered on x
     * (2 * x + 2) would be a palindrome of odd size centered on x
     */

    $count = count($palindromes);

    //For the initial position it's impossible to have an even palindrome centered there
    for($i = (2 * $start + 2), $s = 1; $i < $count - 1; ++$i) {
        //Is the palindrome centered here reaching up to our start position
        if($palindromes[$i] >= $s) {
            //Save the next position after the end of the palindrome
            $results[($i >> 1) + $s - 1] = 1;
        }

        if($i % 2 == 0) {
            ++$s; //Size the palindrome needs to be to reach the start increase
            if((($i >> 1) + $s - 1) > $size) break; //The palindrom would end after the end of the string, we can stop
        }
    }

    return $results;
}

function solve(string $s): int {
    $size = strlen($s);

    /**
     * Use Manacher’s Algorithm to find all the palindromes in the string
     */

    // Preprocess the string with special characters
    $t = '^#' . implode('#', str_split($s)) . '#$';

    $n = strlen($t);
    $palindromes = array_fill(0, $n, 0);
    $center = 0;
    $right = 0;

    for ($i = 1; $i < $n - 1; $i++) {
        if ($i < $right) {
            $palindromes[$i] = min($right - $i, $palindromes[2 * $center - $i]);
        }

        while ($t[$i + $palindromes[$i] + 1] === $t[$i - $palindromes[$i] - 1]) {
            $palindromes[$i]++;
        }

        if ($i + $palindromes[$i] > $right) {
            $center = $i;
            $right = $i + $palindromes[$i];
        }
    }

    $result = 0;
    $second = [];
    $third = [];
    $count = count($palindromes);

    //Find all the positions we can reach with a palindrom starting at position 0
    $second = findPosition(0, $size, $palindromes);

    //Is the whole string a palindrom?
    if(isset($second[$size])) {
        $result += 3;
        unset($second[$size]);
    }

    foreach($second as $positionStart => $filler) {
        //Find all the positions we can reach with a palindrom starting at position $positionStart and sum the occurences
        foreach(findPosition($positionStart, $size, $palindromes) as $position => $filler2) {
            $third[$position] = ($third[$position] ?? 0) + 1;
        }
    }

    //Is the whole string a composition of 2 palindromes?
    if(isset($third[$size])) {
        $result += $third[$size] * 3;
        unset($third[$size]);
    }

    //For the last one we don't care of all the positions we can reach with a palimdrome, we only need to know if the remaining part of the string is a palindrome
    foreach($third as $positionStart => $count) {
        $sizeLeft = $size - $positionStart; //Size of the substring left

        //Find the index that would be the center of the palindrome that completes the string
        $indexToCheck = ($positionStart + ($sizeLeft >> 1)) * 2 + 1;

        //Odd size
        if($sizeLeft & 1) $indexToCheck += 1;
        
        if($palindromes[$indexToCheck] == $sizeLeft) $result += $count;
    }

    return $result;
}

$start = microtime(1);

$string = stream_get_line(STDIN, 4000 + 1, "\n");

echo solve($string) . PHP_EOL;

error_log(microtime(1) - $start);
