<?php

/**
 * Returns 1 when Alice has a solution to win
 * Returns 0 when it's impossible for Alice to win
 */
function solve(string $letter, int $mask, int $player): int {
    global $words;

    $newLetters = [];

    foreach($words as $i => $word) {
        //We can potentially use that word
        if($word[0] == $letter) {
            if(2 ** $i & $mask) continue; //This word was already used

            if(isset($newLetters[$word[-1]])) continue; //We have already tested with this letter
            $newLetters[$word[-1]] = 1;

            $result = solve($word[-1], $mask | 2 ** $i, $player ^ 1);

            //It's Bob turn and he found a solution where he will win
            if($player == 1 && $result == 0) return 0;
            
            //It's Alice turn and she found a solution where she will win
            if($player == 0 && $result == 1) return 1;
        }
    }

    //The player didn't find a solution where he will win
    //player 0 is Alice & player 1 is Bob
    return $player;
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $words[] = trim(fgets(STDIN));
}

$winner = "Bob";

foreach($words as $i => $word) {
    //Check if there's a solution with Alice is sure to win
    if(solve($word[-1], 2 ** $i, 1)) {
        $winner = "Alice";
        break;
    }
}

echo $winner . PHP_EOL;

error_log(microtime(1) - $start);
