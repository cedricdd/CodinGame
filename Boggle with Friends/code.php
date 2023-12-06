<?php

function getScore(int $length): int {
    switch($length) {
        case 3:
        case 4: return 1;
        case 5: return 2;
        case 6: return 3;
        case 7: return 5;
        default: return 11;
    }
}

//Check if a word is in the grid of the boggle
function isValidWord(string $word, array $grid): bool {
    static $history = [];

    if(isset($history[$word])) return $history[$word];

    $length = strlen($word);

    for($y = 0; $y < 4; ++$y) {
        for($x = 0; $x < 4; ++$x) {
            //The word might start here
            if($grid[$y][$x] == $word[0]) {

                $toCheck = [[$x, $y, 0, []]];

                while(count($toCheck)) {
                    [$xp, $yp, $i, $visited] = array_pop($toCheck);

                    if(isset($visited[$yp][$xp])) continue;
                    else $visited[$yp][$xp] = 1;

                    if($grid[$yp][$xp] != $word[$i]) continue; //Wrong letter
                    elseif($length == ++$i) return $history[$word] = true; //Word is complete

                    //We can move horizontally, vertically & diagonally
                    foreach([[0, -1], [-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1], [1, 0], [1, -1]] as [$xm, $ym]) {
                        $xu = $xp + $xm;
                        $yu = $yp + $ym;

                        if($xu >= 0 && $xu < 4 && $yu >= 0 && $yu < 4) $toCheck[] = [$xu, $yu, $i, $visited];
                    }
                }
            }
        }
    }

    return $history[$word] = false;
}

$start = microtime(1);

for ($i = 0; $i < 4; $i++) {
    $grid[] = str_replace(" ", "", trim(fgets(STDIN)));
}

fscanf(STDIN, "%d", $numOfFriendsPlaying);

for ($i = 0; $i < $numOfFriendsPlaying; $i++) {
    preg_match("/([a-zA-Z]+) writes: (.*)/", trim(fgets(STDIN)), $matches);

    $player = $matches[1];
    $scores[$player] = 0;
    $repetition = [];
    
    foreach(explode(" ", $matches[2]) as $word) {
        if(isset($repetition[$word])) continue; //A word only counts once per player
        else $repetition[$word] = 1;

        $occurences[$word] = ($occurences[$word] ?? 0) + 1;

        if(isValidWord($word, $grid)) $words[$player][] = [getScore(strlen($word)), $word];
    }
}

//Calculate the score of each players
foreach($words as $name => $list) {
    foreach($list as $i => [$score, $word]) {
        if($occurences[$word] > 1) unset($words[$name][$i]); //Word is used by multiple players
        else $scores[$name] += $score;
    }

    if(count($words[$name]) == 0) unset($words[$name]); //No words left for this player
}

echo array_search(max($scores), $scores) . " is the winner!" . PHP_EOL . PHP_EOL . "===Each Player's Score===" . PHP_EOL;

foreach($scores as $name => $score) echo $name . " " . $score . PHP_EOL;

echo PHP_EOL . "===Each Scoring Player's Scoring Words===" . PHP_EOL;

foreach($words as $name => $list) {
    echo $name . PHP_EOL;

    foreach($list as [$score, $word]) echo $score . " " . $word . PHP_EOL;
}

error_log(microtime(1) - $start);
