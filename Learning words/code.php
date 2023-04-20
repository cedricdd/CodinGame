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
    
    $counts[$i] = ceil(count($sentences[$i]) / 2); //The amount of words we need to learn in this sentence
}

foreach($sentences as $i => $listWords) {
    $wordsByFrequency = [];
    
    foreach($listWords as $word) $wordsByFrequency[$word] = $words[$word];
    
    $sentences[$i] = $wordsByFrequency;
}

//print_r($sentences);

function solve(array $counts, array $sentences, array $wordsUsage, array $learned, string $hash) {
    global $answer, $wordsID;
    static $history = [];
    
    if(count($learned) >= $answer) return; //We have already learned more words than the current best solution
    
    if(isset($history[$hash])) return; //We have already tested this combinaison of words
    else $history[$hash] = 1;
    
    asort($counts);
    
    foreach($counts as $index => $count) {
        //We are done with this sentence
        if($count == 0) {
            //Update all the words we didn't use in this sentence
            foreach($sentences[$index] as $word => $freq) {
                unset($wordsUsage[$word][$index]);
        
                //Update the count of this word in other sentences
                foreach($wordsUsage[$word] as $indexUsage => $filler) {
                    $sentences[$indexUsage][$word]--;
                }
            }
            
            unset($counts[$index]);
            unset($sentences[$index]);
        } else {
            arsort($sentences[$index]);
    
            //All the words left for this sentence are only appearing in this sentence, doesn't matter witch ones we learn
            if(reset($sentences[$index]) == 1) {
                foreach(array_slice($sentences[$index], 0, $count) as $word => $filler) {
                    $hash[$wordsID[$word]] = 1;
                    $learned[$word] = 1;
                }
    
                unset($counts[$index]); //No need to update info, these words don't affect other sentences
                
                foreach($sentences[$index] as $word => $filler) unset($wordsUsage[$word]);
                
                unset($sentences[$index]);
            } else {
                $first = array_key_first($sentences[$index]); //The # of sentences the most used word is used in
                $affectedSentences = $wordsUsage[$first];
        
                foreach($sentences[$index] as $word => $frequency) {
                    if($frequency == 1) break; //We only do recursive calls for words that appear in at least 2 sentences
            
                    $hashUpdated = $hash;
                    $updatedCounts = $counts;
                    $updatedSentences = $sentences;
                    $wordsUsageUpdated = $wordsUsage;
            
                    foreach($wordsUsageUpdated[$word] as $indexUsage => $filler) {
                        unset($updatedSentences[$indexUsage][$word]);
                        $updatedCounts[$indexUsage]--;
                    }
    
                    $hashUpdated[$wordsID[$word]] = 1;
                    unset($wordsUsageUpdated[$word]);
            
                    solve($updatedCounts, $updatedSentences, $wordsUsageUpdated, $learned + [$word => 1], $hashUpdated);
                }
                
                return;
            }
        }
    }
    
    //We have found a better solution
    if(count($learned) < $answer) $answer = count($learned);
}

$answer = INF;

solve($counts, $sentences, $wordsUsage, [], str_repeat("0", count($wordsID)));

echo $answer . PHP_EOL;
error_log(microtime(1) - $start);
