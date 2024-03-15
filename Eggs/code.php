<?php

function placeEggs(int $position, int $nbrEggs, int $gridA, int $gridB) {
    global $w, $h, $size, $results;
    static $count = 0;

    if($nbrEggs == 0) {
        $pa = log($gridA & -$gridA) / log(2);
        $pb = log($gridB & -$gridB) / log(2);

        if($pa == $pb) {
            error_log("$count -- GridA: $gridA " . str_pad(decbin($gridA), $size, '0', STR_PAD_LEFT) . " -- " . $pa);
            error_log("$count -- GridB: $gridB " . str_pad(decbin($gridB), $size, '0', STR_PAD_LEFT) . " -- " . $pb);
        }

        
        ++$count;

        if($pa < $pb) {
            $results['A']++;
            error_log("A wins");
        }
        elseif($pb < $pa) {
            error_log("B wins");
            $results['B']++;
        }
        else {
            error_log("tie");
            $results['T']++;
        }

        return;
    }
    if($position == $size) return;

    //Don't place an egg at $position
    placeEggs($position + 1, $nbrEggs, $gridA, $gridB);
    
    //Place an egg at $position
    $gridA |= (1 << (($position % $h) * $w + intdiv($position, $h)));
    $gridB |= (1 << $position);

    placeEggs($position + 1, $nbrEggs - 1, $gridA, $gridB);
}

$start = microtime(1);

fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $n);

$results = ['A' => 0, 'B' => 0, 'T' => 0];
$size = $w * $h;

placeEggs(0, $n, 0, 0);

error_log(var_export($results, true));

$total = array_sum($results);
echo number_format($results['A'] / $total * 100, 2) . "%" . PHP_EOL;
echo number_format($results['B'] / $total * 100, 2) . "%" . PHP_EOL;
echo number_format($results['T'] / $total * 100, 2) . "%" . PHP_EOL;

error_log(microtime(1) - $start);
