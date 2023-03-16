<?php

function solve(string $sentence, array $words, array $result) {
    global $solutions;

    //We have used all the words, we have found a solution
    if(empty($sentence)) {
        $solutions[] = $result;
        return;
    } else $indexWord = count($result); //The index of the next word

    //We test all the words that are left
    foreach($words as $size => $list) {
        $match = substr($sentence, 0, $size);
        $rest = substr($sentence, $size);

         foreach($list as $word => $count) {
            //If the sentence starts with the word, we try to use that word
            if($match == $word) {
                $wordsUpdated = $words;

                if($count == 1) { 
                    if(count($list) == 1) unset($wordsUpdated[$size]); //This was the last word of this size
                    else unset($wordsUpdated[$size][$word]);  //We can't use this word anymore
                }
                else $wordsUpdated[$size][$word]--; //We can use this word again

                solve($rest, $wordsUpdated, $result + [$indexWord => $word]);
            }
         }
    }
}


$original = trim(fgets(STDIN));
foreach(explode(" ", trim(fgets(STDIN))) as $word) {
    $size = strlen($word);

    if(isset($words[$size][$word])) $words[$size][$word]++;
    else $words[$size][$word] = 1;
}

solve($original, $words, []);

//No ambiguity, only one way to decipher it
if(count($solutions) == 1) echo implode(" ", $solutions[0]) . PHP_EOL;
//We don't know which solutions is the right one
else echo "Unsolvable" . PHP_EOL;
