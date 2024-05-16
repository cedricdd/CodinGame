<?php

//Check if a word is a palindrome
function isPalindrome(string $word): int {
    static $history = [];

    if(isset($history[$word])) return $history[$word];
    else return $history[$word] = ($word == strrev($word) ? 1 : 0);
}

//Check if a word is a near palindrom
function isNearPalindrome(string $word): int {
    $size = strlen($word);

    $limit = $size >> 1;

    for($i = 0; $i < $limit; ++$i) {
        if($word[$i] != $word[$size - 1 - $i]) {
            //We try to replace it
            if(isPalindrome(substr($word, $i + 1, ($i + 1) * -1))) return 1;

            //We try to remove it -- no need to check addition it's the inverse of removal
            if(isPalindrome(substr_replace($word, "", $i, 1))) return 1;
            if(isPalindrome(substr_replace($word, "", $size - 1 - $i, 1))) return 1;

            return 0;
        }
    }

    return 1;
}

$start = microtime(1);

$solution = "";

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $word = trim(fgets(STDIN));

    $solution .= isNearPalindrome($word);
}

echo $solution . PHP_EOL;

error_log(microtime(1) - $start);
