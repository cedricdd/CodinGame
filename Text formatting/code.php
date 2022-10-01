<?php

$input = trim(fgets(STDIN));
$input = preg_replace('/\s{2,}/', ' ', $input); //Remove excessive spaces.
$input = preg_replace('/(\s?(\W)\s?)/', '$2', $input); //4rmove spaces before & after punctuation marks.
$input = preg_replace('/(\W)\1+/', '$1', $input); //Remove repeated punctuation marks.
$input = preg_replace('/([^\w ])/', '$1 ', $input); //Add a space after punctuation marks.

echo implode(" ", array_map(function ($sentence) {
    //Use only lowercase letters, except for the beginning of the sentence.
    return ucfirst(trim(strtolower($sentence)));
}, preg_split("/([^\.]*\.\s)/", $input, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY))) . PHP_EOL;
?>
