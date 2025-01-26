<?php

//We are setting a clue as being incorrect
function removeClue(array &$clues, string $nameIncorrect): bool {

    foreach($clues as [&$count, &$listClues]) {
        //This line is using the incorrect clue
        if(isset($listClues[$nameIncorrect])) {
            unset($listClues[$nameIncorrect]);

            --$count;

            //We now only have one clue left in the line, so that clue must be treated as correct
            if($count == 1) {
                $nameCorrect = array_key_first($listClues);


                if(correctClue($clues, $nameCorrect) === false) return false;
            } 
            elseif($count == 0) return false; //We don't have any clue left in this line => invalid
        }
    }

    return true;
}

//We are setting a clue as being correct
function correctClue(array &$clues, string $nameCorrect): bool {
    foreach($clues as $i => [$count, &$listClues]) {
        if($count <= 1) continue; //Nothing to do here

        //That clue is ussed in this line
        if(isset($listClues[$nameCorrect])) {
            foreach($listClues as $clueName => $filler) {
                if($clueName == $nameCorrect) continue;

                //Every other clues on the line can't be correct
                if(removeClue($clues, $clueName) === false) return false;
            }
        }
    }

    return true;
}

function solve(array $clues) {
    global $start;

    $conflicts = [];

    //Generate all the conflicts from the current clues
    foreach($clues as [$count, $list]) {
        if($count > 1) {
            foreach($list as $clueName1 => $filler1) {
                foreach($list as $clueName2 => $filler2) {
                    if($clueName1 == $clueName2) continue;

                    $conflicts[$clueName1][$clueName2] = 1;
                    $conflicts[$clueName2][$clueName1] = 1;
                }
            }
        }
    }

    foreach($conflicts as $name => $list) {
        //Check if any clue can't be associated with all the suspects
        foreach($clues[0][1] as $suspect => $filler) {
            if(!isset($list[$suspect])) continue 2;
        }
    
        //This clue can't be associated with any of the suspects left, it's an incorrect clue
        if(removeClue($clues, $name) === false) return;
    }

    $clueID = null;
    $clueCount = PHP_INT_MAX;

    //When we make a guess we use the clues with the less possibilities
    foreach($clues as $id => [$count, ]) {
        //Find the line with more than one clue with the least amount of clues
        if($count > 1 && $count < $clueCount) {
            $clueCount = $count;
            $clueID = $id;
        }
    }

    //All the lines only have one clue, we are over
    if($clueID === null) {
        echo array_key_first($clues[0][1]) . PHP_EOL;
        error_log(microtime(1) - $start);
        exit();
    } else {
        //We need to make a guess, we use the clues with the less possibilities
        foreach($clues as $id => [$count, ]) {
            if($count > 1 && $count < $clueCount) {
                $clueCount = $count;
                $clueID = $id;
            }
        }

        //Test all the possibilities for the line
        foreach($clues[$clueID][1] as $clueName => $filler) {
             $clues2 = $clues;

            if(correctClue($clues2, $clueName)) solve($clues2);
        }
    }
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);
for($k = 0; $k < $N; $k++) {
    $input = explode(", ", trim(fgets(STDIN)));

    $count = count($input); //We save how many clues we have on each lines
    $clues[] = [$count, array_flip($input)];
}

solve($clues);
