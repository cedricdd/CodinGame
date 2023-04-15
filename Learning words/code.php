<?php

$start = microtime(1);

$wordsID = [];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $sentences[] = explode(" ", strtolower(trim(fgets(STDIN))));

    foreach($sentences[$i] as $word) {
        $words[$word] = ($words[$word] ?? 0) + 1;
        $wordsUsage[$word][$i] = 1;
        
        if(!isset($wordsID[$word])) $wordsID[$word] = count($wordsID);
    }
    
    $counts[$i] = ceil(count($sentences[$i]) / 2);
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
    
    if(count($learned) >= $answer) return;
    
    
    if(isset($history[$hash])) return;
    else $history[$hash] = 1;
    
    asort($counts);
    
    foreach($counts as $index => $count) {
        //echo "Working on sentence $index, we need $count more word(s)" . PHP_EOL;
        
        if($count == 0) {
            //echo "We are done with sentence $index, update info" . PHP_EOL;
            //print_r($sentences[$index]);
            
            foreach($sentences[$index] as $word => $freq) {
                unset($wordsUsage[$word][$index]);
        
                foreach($wordsUsage[$word] as $indexUsage => $filler) {
                    $sentences[$indexUsage][$word]--;
            
                    //echo "Updating the count for the word $word on sentence $indexUsage" . PHP_EOL;
                }
            }
            
            unset($counts[$index]);
            unset($sentences[$index]);
        } else {
            arsort($sentences[$index]);
    
            if(reset($sentences[$index]) == 1) {
                //echo "We only have words with 1 frenquency for this sentence" . PHP_EOL;
    
                foreach(array_slice($sentences[$index], 0, $count) as $word => $filler) {
                    $hash[$wordsID[$word]] = 1;
                    $learned[$word] = 1;
                }
    
                unset($counts[$index]); //No need to update info, these words don't affect other sentences
                
                foreach($sentences[$index] as $word => $filler) unset($wordsUsage[$word]);
                
                unset($sentences[$index]);
            } else {
                $first = array_key_first($sentences[$index]);
                $affectedSentences = $wordsUsage[$first];
        
                foreach($sentences[$index] as $word => $frequency) {
                    if($frequency == 1) break;
                    
                    if($word != $first) {
                        do {
                            foreach($wordsUsage[$word] as $indexUsage => $filler) {
                                if(!isset($affectedSentences[$indexUsage])) break 2;
                            }
                            
                            continue 2;
                        } while(true);
                    }
            
                   // echo "We are using $word for sentence $index" . PHP_EOL;
            
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
    
    
    if(count($learned) < $answer) {
        $answer = count($learned);
        error_log("We are done, we have learned " . count($learned) . " words");
        ksort($learned);
        error_log(implode(", ", array_map(function($word) {
            return "\"" . $word . "\"";
        }, array_keys($learned))));
    }
}

$answer = INF;

solve($counts, $sentences, $wordsUsage, []);

echo $answer . PHP_EOL;
error_log("Answer: $answer -- Memory: " . memory_get_usage() . " -- Total time: " . (microtime(1) - $start));
