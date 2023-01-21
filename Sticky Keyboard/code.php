<?php

$words = [];
$replacements = [];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $line = trim(fgets(STDIN));

    //Get all the "words", any non a-z characters is a word break
    $inputs = preg_split("/[^a-z]+/", $line, -1, PREG_SPLIT_NO_EMPTY);

    //We need the instances  of each words
    foreach($inputs as $word) $words[$word] = ($words[$word] ?? 0) + 1;

    $text[] = $line;
}

foreach($words as $word => $count) {
    for($i = 0; $i < strlen($word); ++$i) {
        $reference = substr_replace($word, "", $i, 1);

        if(isset($words[$reference])) {
            if($i > 0 && $word[$i - 1] == $word[$i] && $words[$reference] > $count) $replacements[$word] = $reference; //Repeating character
            elseif($words[$reference] < $count) $replacements[$reference] = $word; //Missing character
        }
    }
}

echo implode("\n", array_map(function($line) use ($replacements) {
    //Replace all the incorrect words, we shouldn't replace sub-part of words
    foreach($replacements as $from => $to) {
        $line = preg_replace("/(?<=[^a-z]|^)" . $from . "(?=[^a-z]|$)/", $to, $line);
    }

    return $line;
}, $text)) . PHP_EOL;
