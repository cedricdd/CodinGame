<?php

$player = 1;
$start = 0;

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    [$minutes, $seconds] = explode(":", trim(fgets(STDIN)));

    $time = $minutes * 60 + $seconds; //The current time

    if($time < $start) break; //Game has already started
   
    $start = max($time - 256 / (2 ** ($player - 1)), 0); //The new start time

    //Room is now full
    if(++$player == 8) {
        $start = $time;
        break;
    }
}

if($player == 1) echo "NO GAME" . PHP_EOL; //Nobody joined
else echo intdiv($start, 60) . ":" . str_pad($start % 60, 2, "0", STR_PAD_LEFT) . PHP_EOL;
