<?php

$anagram = trim(fgets(STDIN));
$lengthAnagram = strlen($anagram);
$anagramLetters = count_chars(strtolower($anagram), 1);

$sentence = trim(fgets(STDIN));
$totalLetters = strlen(preg_replace("/[^a-zA-Z]/", "", $sentence));
$words = preg_split("/[ :.,?!]/", $sentence, -1, PREG_SPLIT_NO_EMPTY);
$leftLetters = 0;
$leftWords = 0;

foreach($words as $i => $word) {
    $length = strlen($word);

    //Check if the current word is the first anagram
    if($length == $lengthAnagram && strcmp($word, $anagram) !== 0) {
        if(count_chars(strtolower($word), 1) == $anagramLetters) {
            exit(strval($i)[-1] . "." . strval(count($words) - $i - 1)[-1] . "." . strval($leftLetters)[-1] . "." . strval($totalLetters - $leftLetters - $length)[-1]);
        }
    }

    $leftLetters += $length;
    $leftWords += 1;
}

echo "IMPOSSIBLE" . PHP_EOL;
