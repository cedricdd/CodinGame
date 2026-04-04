<?php

function checkLiars(array $liars): bool {
    global $sentences;

    foreach($sentences as [$chain, $last, $action]) {
        $expected = $liars[$last] ? $action == 'L' : $action == 'T'; 

        //Each liars in the chain will switch the truth, we want to know the total number of switches
        $count = 0;

        foreach($chain as $person => $occ) if($liars[$person]) $count += $occ;

        //If the number of liars is even then they cancel each others and the last part must be the truth
        if($count % 2 == $expected) return false;
    }

    return true;
}

function generateLiars(int $i, int $s, array &$liars): ?array {
    global $N, $L;

    if($s == 0) return checkLiars($liars) ? $liars : null;

    if($i == $N) return null; //Nobody left to select
    if($N - $i < $s) return null; //Not enough people left to select

    $result = generateLiars($i + 1, $s, $liars);

    if($result) return $result;

    $liars[$i] = true;

    $result = generateLiars($i + 1, $s - 1, $liars);

    $liars[$i] = false;

    return $result;
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $L);

for ($i = 0; $i < $N; $i++) {
    $sentence = stream_get_line(STDIN, 1024 + 1, "\n");

    preg_match("/(\d(?:>\d)*)=([TL])/", $sentence, $matches);

    $chain = explode(">", $matches[1]);
    $last = array_pop($chain);
    $counts = array_fill(0, $N, 0);

    foreach($chain as $person) $counts[$person]++;

    $sentences[] = [$counts, $last, $matches[2]];
}

$liars = array_fill(0, $N, false);
$liars = generateLiars(0, $L, $liars);

//Keep only liars
$liars = array_filter($liars);

ksort($liars); //We want the liars in ascending order

echo implode(" ", array_keys($liars)) . PHP_EOL;

error_log(microtime(1) - $start);
