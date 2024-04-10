<?php

$start = microtime(1);

function solve(int $value, array $register, array $coins, int $count) {
    global $solution;
    static $history = [];

    //If we have already reached the same value with less coins, no need to continue
    if(isset($history[$value]) && $history[$value] < $count) return;
    else $history[$value] = $count;

    if($count >= $solution[1]) return; //Current solution uses less coins

    $coin = array_pop($register); //Next coin to work on

    if($coin > $value) solve($value, $register, $coins, $count); //Coin value is too big
    //If we can reach the value with only using this coin it's the best solution
    elseif($value % $coin == 0) {
        $occ = intdiv($value, $coin);

        if($count + $occ >= $solution[1]) return;

        $coins[$coin] = $occ;
        $solution = [$coins, $count + $occ];

        return;
    } else {
        //How many of this coin can we add
        $occurences = intdiv($value, $coin);

        //Test with every possibility
        for($i = $occurences; $i >= 0; --$i) {
            $coins[$coin] = $i;
            solve($value - $i * $coin, $register, $coins, $count + $i);
        }
    }
}

$register = explode(" ", trim(fgets(STDIN)));
fscanf(STDIN, "%d", $goalAmount);

if($goalAmount == 0) exit("0");

$solution = [[], INF];

solve($goalAmount, $register, [], 0);

$output = [];

foreach($solution[0] as $coin => $value) {
    $output = array_merge($output, array_fill(0, $value, $coin));
}

echo implode(" ", $output) . PHP_EOL;

error_log(microtime(1) - $start);
