<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $sentences[] = explode(" ", strtolower(trim(fgets(STDIN))));

    foreach($sentences[$i] as $word) {
        $words[$word] = ($words[$word] ?? 0) + 1; //Save the word frequency among all sentences
    }
}

$learned = [];

foreach($sentences as $sentence) {
    $list = [];
    $wordsNeeded = ceil(count($sentence) / 2);

    foreach($sentence as $word) {
        if(isset($learned[$word])) --$wordsNeeded; //We already know this word
        else $list[$word] = $words[$word]; //This word could be leaned

        $words[$word]--; //Update frenquecu without this sentence
    }

    arsort($list); //We want to learn the words that are the most used in other sentences first

    while($wordsNeeded > 0) {
        $learned[key($list)] = 1;
    
        --$wordsNeeded;
        next($list);
    }
}

echo count($learned) . PHP_EOL;
