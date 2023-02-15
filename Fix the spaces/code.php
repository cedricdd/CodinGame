<?php

function solve(string $sentence, array $words, array $list) {
    global $solutions;

    //We have used all the words, we have found a solution
    if(empty($sentence)) {
        $solutions[] = $list;
        return;
    } else $indexWord = count($list); //The index of the next word

    //We test all the words that are left
    foreach($words as $word => [$count, $size]) {
        //If the sentence starts with the word, we try to use that word
        if(substr($sentence, 0, $size) == $word) {
            $wordsUpdated = $words;

            if($wordsUpdated[$word][0]-- == 1) unset($wordsUpdated[$word]); 

            solve(substr($sentence, $size), $wordsUpdated, $list + [$indexWord => $word]);
        }
    }
}

$original = trim(fgets(STDIN));
foreach(explode(" ", trim(fgets(STDIN))) as $word) {
    if(isset($words[$word])) $words[$word][0]++;
    else $words[$word] = [1, strlen($word)];
}
$solutions = [];

solve($original, $words, []);

//No ambiguity, only one way to decipher it
if(count($solutions) == 1) echo implode(" ", $solutions[0]) . PHP_EOL;
//We don't know which solutions is the right one
else echo "Unsolvable" . PHP_EOL;
