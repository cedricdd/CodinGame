<?php

//Use Manacher’s Algorithm to find all the palindromes in the string
function findPalindrome(string $s): array {
    // Preprocess the string with special characters
    $t = '^#' . implode('#', str_split($s)) . '#$';

    $n = strlen($t);
    $p = array_fill(0, $n, 0);
    $center = 0;
    $right = 0;

    for ($i = 1; $i < $n - 1; $i++) {
        if ($i < $right) {
            $p[$i] = min($right - $i, $p[2 * $center - $i]);
        }

        while ($t[$i + $p[$i] + 1] === $t[$i - $p[$i] - 1]) {
            $p[$i]++;
        }

        if ($i + $p[$i] > $right) {
            $center = $i;
            $right = $i + $p[$i];
        }
    }

    $count = count($p);
    $results = [];

    for($i = 1, $j = 0; $i < $count - 1; ++$i) {
        if($p[$i] == 0) continue;

        $start = $i >> 1;

        //We save the position of the start of the palindrome and the next position after the palindrome
        if($i % 2 == 0) { //Odd size palindrome
            for($j = $p[$i] >> 1; $j >= 0; --$j) {
                $results[$start - $j - 1][$start + $j] = 1;
            }
        } else { //Even size palindrome
            for($j = $p[$i] >> 1; $j > 0; --$j) {
                $results[$start - $j][$start + $j] = 1;
            }
        }
    }

    return $results;
}

$start = microtime(1);

$string = stream_get_line(STDIN, 4000 + 1, "\n");
$size = strlen($string);
$count = 0;
$palindromes = findPalindrome($string);
$partial = [];

foreach($palindromes[0] as $startSecond => $filler) {
    //The whole string is a palindrome
    if($startSecond == $size) {
        $count += 3;
        continue;
    }

    foreach($palindromes[$startSecond] as $startThird => $filler) {
        //The two first palindromes represent the whole string
        if($startThird == $size) {
            $count += 3;
            continue;
        }

        //Save all the positions we can reach with 2 palindromes and how many times we can reach them
        $partial[$startThird] = ($partial[$startThird] ?? 0) + 1;
    }
}

foreach($partial as $index => $value) {
    //Check if the remaining part of the string is a palindrome
    if(isset($palindromes[$index][$size])) $count += $value;
}

echo $count . PHP_EOL;

error_log(microtime(1) - $start);
