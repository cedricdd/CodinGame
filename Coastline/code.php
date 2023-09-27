<?php
fscanf(STDIN, "%d", $n);
for ($i = 1; $i <= $n; $i++) {
    $info = explode(" ", trim(fgets(STDIN)));

    $islets = [];
    $nIslets = array_shift($info);
    $radius = array_shift($info);

    while($info) {
        $x = array_shift($info);
        $y = array_shift($info);

        //This islet can't be reached
        if($y > $radius) {
            echo "-1" . PHP_EOL;
            continue 2;
        }

        $islets[] = [$x, $y, $x + sqrt(($radius ** 2) - ($y ** 2))];
    }

    //Sort islets by minimal position of transmitter
    usort($islets, function($a, $b) {
        return $a[2] <=> $b[2];
    });

    $count = 0;
    $transmitter = -INF;

    foreach($islets as [$x, $y, $t]) {
        //We need to place a new transmitter, this islet isn't in reach of the last transmitter added
        if(sqrt(($x - $transmitter) ** 2 + $y ** 2) > $radius) {
            ++$count;

            $transmitter = $t;
        }
    }

    echo $count . PHP_EOL;
}
