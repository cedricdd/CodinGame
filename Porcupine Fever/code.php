<?php

$cages = [];

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $Y);
for ($i = 0; $i < $N; $i++) {
    $cages[] = explode(" ", trim(fgets(STDIN)));
}

for ($i = 0; $i < $Y; $i++) {

    $alive = 0;

    foreach($cages as $cage => [&$sick, &$healthy, &$total]) {
        //All the porcupines are dead in this cage
        if($total == 0) {
            unset($cages[$cage]);
            continue;
        }

        $total -= $sick; //The sick ones are dying
        $sick = min($sick * 2, $healthy); //Each sick one will contaminate 2 healthy ones
        $healthy -= $sick; //Pool of healthy decrease
        $alive += $total;
    }

    echo $alive . PHP_EOL;

    //All the porcupines are dead
    if($alive == 0) break;
}
