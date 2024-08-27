<?php

function solve(int $remainder, int $n): string {
    $decimal = "";
    $index = 0;
    $history = [];

    //Generate the decimal part
    while(!isset($history[$remainder])) {
        $history[$remainder] = $index++;
        $remainder *= 10;
        $decimal .= intdiv($remainder, $n);
        $remainder %= $n;
    }

    if($remainder == 0) return substr($decimal, 0, -1); //There's no repeating part
    else return substr($decimal, 0, $history[$remainder]) . "(" . substr($decimal, $history[$remainder]) . ")";
}

$start = microtime(1);

fscanf(STDIN, "%d", $n);

echo "0." . solve(1, $n) . PHP_EOL;

error_log(microtime(1) - $start);
