<?php

function placeEggs(int $position, int $nbrEggs, int $gridA, int $gridB) {
    global $w, $h, $results;

    if($nbrEggs == 0) {
        /** 
         * x & -x sets every bits but the rightmost to 0, which is the first dice encountered by the player.
         * We know the result is a power of 2 so we use binary logarithm to get the position of the bit set to 1.
         */
        $pa = log($gridA & -$gridA, 2);
        $pb = log($gridB & -$gridB, 2);

        if($pa < $pb) $results['A']++; //Alice wins
        elseif($pb < $pa) $results['B']++; //Bob wins
        else $results['T']++; //It's a tie

        return;
    }
    if($position == $w * $h) return;

    //Don't place an egg at $position
    placeEggs($position + 1, $nbrEggs, $gridA, $gridB);

    //Place an egg at $position
    $gridA |= (1 << intdiv($position, $w) + ($position % $w) * $h); //Find the equivalent position for Alice
    $gridB |= (1 << $position); //Bob follows the 'natural' path

    placeEggs($position + 1, $nbrEggs - 1, $gridA, $gridB);
}

$start = microtime(1);

fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $n);

$results = ['A' => 0, 'B' => 0, 'T' => 0];

placeEggs(0, $n, 0, 0);

$total = array_sum($results);
echo number_format($results['A'] / $total * 100, 2) . "%" . PHP_EOL;
echo number_format($results['B'] / $total * 100, 2) . "%" . PHP_EOL;
echo number_format($results['T'] / $total * 100, 2) . "%" . PHP_EOL;

error_log(microtime(1) - $start);
