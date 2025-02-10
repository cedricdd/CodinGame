<?php

function solve(array $patterns, int $snakeID): int {
    global $snakes, $success, $history;

    $hash = implode("-", $patterns);

    if(isset($history[$hash][$snakeID])) return $history[$hash][$snakeID]; //Using history we already know the result

    //We placed all the snakes
    if($snakeID == $success) {
        if(strpos($hash, '#') !== false) return 0; //Invalid solution we still have some character representing a snake
        else return 1;
    }

    $pattern = array_pop($patterns);

    if($pattern === null) return 0; //Nowhere left to place a snake

    $s1 = $snakes[$snakeID];
    $s2 = strlen($pattern);
    $count = 0;

    //Not enough space left for the next snake
    if($s1 > $s2) {
        if(strpos($pattern, '#') === false) return $history[$hash][$snakeID] = solve($patterns, $snakeID); //Everything left can be a free space
        else return $history[$hash][$snakeID] = 0; //Invalid solution
    }

    $max = $s2 - $s1;

    //Test all the start position for the snake
    for($i = 0; $i <= $max; ++$i) {
        if($i + $s1 == $s2) $count += solve($patterns, $snakeID + 1); //We are using everything that's left
        elseif($pattern[$i + $s1] != '#') {
            $patterns[] = substr($pattern, $i + $s1 + 1); //We can add more snakes in the part of the pattern that's left

            $count += solve($patterns, $snakeID + 1);

            array_pop($patterns);
        }

        if($pattern[$i] == '#') return $history[$hash][$snakeID] = $count; //We can't skip snake parts
    }

    if(strpos($pattern, '#') === false) $count += solve($patterns, $snakeID); //We can consider that evertying should be empty space

    return $history[$hash][$snakeID] = $count;
}

$start = microtime(1);

fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; $i++) {
    $history = [];

    [$pattern, $snakes] = explode(" ", trim(fgets(STDIN)));
    preg_match_all("/[\?\#]+/", $pattern, $matches);

    $snakes = explode(",", $snakes);
    $success = count($snakes);

    echo solve(array_reverse($matches[0]), 0) . PHP_EOL;
}

error_log(microtime(1) - $start);
