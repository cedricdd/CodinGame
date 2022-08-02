<?php

fscanf(STDIN, "%s", $string);
//Using Manacher Algorithm for find the Longest Palindrome
$length = strlen($string) * 2 + 1;
$chars = array_fill(0, $length, "#");

foreach(str_split($string) as $x => $c) {
    $chars[$x * 2 + 1] = $c;
}

$maxLength = 0;
$maxRight = 0;
$center = 0;
$p = array_fill(0, $length, 0);

for($i = 0; $i < $length; ++$i) {
    if($i < $maxRight) {
        $p[$i] = min($maxRight - $i, $p[2 * $center - $i]);
    }

    // Expanding along the center
    while (true) {
        $left = $i - $p[$i] - 1;
        $right = $i + $p[$i] + 1;

        if($left < 0 || $right >= $length || $chars[$left] != $chars[$right]) break;

        $p[$i]++;
    }

    // Updating center and right bound
    if ($i + $p[$i] > $maxRight) {
        $center = $i;
        $maxRight = $i + $p[$i];
    }

    //We found a new palindrome bigger than the current longest one
    if($p[$i] > $maxLength) {
        $maxLength = $p[$i];
        $palindroms = [substr($string, ceil(($i - $p[$i] - 1) / 2), $p[$i])];
    } //We found a new palindrome with the same length as the current longest one 
    elseif($p[$i] == $maxLength) {
        $palindroms[] = substr($string, ceil(($i - $p[$i] - 1) / 2), $p[$i]);
    }
}

echo implode("\n", $palindroms) . "\n";  
?>
