<?php
fscanf(STDIN, "%d", $d);
fscanf(STDIN, "%d", $c);
fscanf(STDIN, "%d", $n);

$goods = [];

for ($i = 0; $i < $n; $i++){
    fscanf(STDIN, "%d %d %d", $unitCost, $unitRevenue, $quantity);

    if($unitRevenue > $unitCost) $goods[] = [$unitCost, $unitRevenue, $quantity];
}

for($i = 0; $i < $d; ++$i) {
    $bestCash = 0;
    $bestID = null;
    $bestQuantity = 0;

    foreach($goods as $id => [$unitCost, $unitRevenue, $quantity]) {
        $max = min($quantity, intdiv($c, $unitCost));

        $gain = $unitRevenue * $max + ($c - $unitCost * $max);

        if($gain > $bestCash) {
            $bestCash = $gain;
            $bestID = $id;
            $bestQuantity = $max;
        }
    }

    if($bestCash == 0) break;

    $c = $bestCash;
    $goods[$bestID][2] -= $bestQuantity;
}

echo $c . PHP_EOL;
