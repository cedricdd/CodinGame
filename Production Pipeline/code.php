<?php

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d", $k);
for ($i = 0; $i < $k; $i++) {
    [$a, $b] = explode("<", trim(fgets(STDIN)));

    $needed[$b][] = $a;
}

$order = [];
$processes = array_fill(1, $n, true);

for($i = 0; $i < $n; ++$i) {
    //We want to run the process with the lowest ID
    foreach($processes as $process => $filler) {
        //Make sure we can run this process
        foreach($needed[$process] ?? [] as $requirement) {
            if(isset($processes[$requirement])) continue 2;
        }

        $order[] = $process;
        unset($processes[$process]);

        continue 2;
    }

    exit("INVALID");
}

echo implode(" ", $order) . PHP_EOL;
