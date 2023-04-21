<?php

$start = microtime(1);

$wordsID = [];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $sentences[] = explode(" ", strtolower(trim(fgets(STDIN))));
    
    foreach($sentences[$i] as $word) {
        $words[$word] = ($words[$word] ?? 0) + 1; //The amounts of times this word is used globally
        $wordsUsage[$word][$i] = 1; //The sentences where this word is used
        
        if(!isset($wordsID[$word])) $wordsID[$word] = count($wordsID); //We keep a list of unique words
    }
}

foreach($sentences as $i => $listWords) {
    $wordsByFrequency = [];
    
    foreach($listWords as $word) $wordsByFrequency[$word] = $words[$word];
    
    $sentences[$i] = $wordsByFrequency;
}

function solve(array $sentences, int $learned, string $hash) {
    global $answer, $wordsID, $wordsUsage;
    static $history = [];
    
    if($learned >= $answer) return; //We have already learned more words than the current best solution
    
    if(isset($history[$hash])) return; //We have already tested this combinaison of words
    else $history[$hash] = 1;

    //We want to work on the sentence that has the least words appearting in other sentences
    uasort($sentences, function($a, $b) {
        $countA = count(array_filter($a, function($v) { return $v > 1; }));

        $countB = count(array_filter($b, function($v) { return $v > 1; }));

        return $countA <=> $countB;
    });
    
    foreach($sentences as $index => $list) {
        arsort($list);

        //All the words left for this sentence are only appearing in this sentence, doesn't matter witch one we learn
        if(reset($list) == 1) {
            $word = array_key_first($list);

            $hash[$wordsID[$word]] = 1;
            ++$learned;

            unset($sentences[$index]);
        } else {
            foreach($list as $wordUsed => $frequency) {
                if($frequency == 1) break; //We only do recursive calls for words that appear in at least 2 sentences

                $hashUpdated = $hash;
                $updatedSentences = $sentences;
        
                //All the sentences this word is appearing are now good
                foreach($wordsUsage[$wordUsed] as $indexUsage => $filler) {
                    unset($updatedSentences[$indexUsage]);
                }

                $hashUpdated[$wordsID[$wordUsed]] = 1;
                
                //Update the count of all the words we didn't not learn for this sentence
                foreach($sentences[$index] as $wordLeft => $usage) {

                    if($usage == 1 || $wordLeft == $wordUsed) continue;

                    foreach($wordsUsage[$wordLeft] as $indexUsage => $filler) {
                        if(isset($updatedSentences[$indexUsage])) $updatedSentences[$indexUsage][$wordLeft]--;
                    }
                }
        
                solve($updatedSentences, $learned + 1, $hashUpdated);
            }
            
            return;
        }
    }
    
    //We have found a better solution
    if($learned < $answer) $answer = $learned;
}

$answer = INF;

solve($sentences, 0, str_repeat("0", count($wordsID)));

echo $answer . PHP_EOL;
error_log(microtime(1) - $start);
