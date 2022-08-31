<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s", $words[]);
}

asort($words); //Sort words alphavetically
$prevBreak = 0;

//Now that words are sorted we only have to compare the current word with the next one in the list
for($i = 0; $i < count($words); ++$i) {
    $word = current($words);
    $index = key($words);
    $next = next($words);
    $break = 0;

    //For the last one we have nothing to compare it with
    if($next !== false) {
        for(; $break < strlen($word); ++$break) {
            if($word[$break] != $next[$break]) break;
        }
    }

    //Prefix is the max between the break points with the next & previous word
    $words[$index] = substr($word, 0, max($break, $prevBreak) + 1);
    $prevBreak = $break;
}

ksort($words); //Switch back to the display order

echo implode("\n", $words) . PHP_EOL;
?>
