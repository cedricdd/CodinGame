<?php

$anagram = trim(fgets(STDIN));
$anagramCounts = count_chars(strtolower($anagram), 1);

$words = [0, 0];
$letters = [0, 0];
$key = 0;

foreach(preg_split("/[ \:\.\,\?\!]/", trim(fgets(STDIN)), -1, PREG_SPLIT_NO_EMPTY) as $word) {
    //A word is not an anagram of itself & we only care about the first anagram
    if($key == 0 && $anagram != $word &&  $anagramCounts == count_chars(strtolower($word), 1)) {
        $key = 1;
        continue;
    }

    $words[$key]++;
    $letters[$key] += strlen($word);
}

if($key == 0) echo "IMPOSSIBLE" . PHP_EOL;
else echo strval($words[0])[-1] . "." . strval($words[1])[-1] . "." . strval($letters[0])[-1] . "." . strval($letters[1])[-1] . PHP_EOL;
