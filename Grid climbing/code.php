<?php

$start = microtime(1);

fscanf(STDIN, "%d", $n);

$lastPosition = $n * $n - 1;
$costs = explode(" ", stream_get_line(STDIN, 256 + 1, "\n"));

for ($i = 0; $i < $n; $i++) {
    $map[] = stream_get_line(STDIN, $n + 1, "\n");
}

//Pre-compute the jumps cost, jumping between position ia (xa;ya) && position ib (xb;yb)
for($ya = 0; $ya < $n; ++$ya) {
    for($xa = 0; $xa < $n; ++$xa) {
        $ia = $ya * $n + $xa;
        for($yb = 0; $yb < $n; ++$yb) {
            for($xb = 0; $xb < $n; ++$xb) {
                $ib = $yb * $n + $xb;
                if(isset($jumps[$ia][$ib]) || $ia == $ib) continue;

                $jumpCost = $costs[max(abs($xa - $xb), abs($ya - $yb)) - 1];
                $jumps[$ia][$ib] = $jumpCost + $map[$yb][$xb];
                $jumps[$ib][$ia] = $jumpCost + $map[$ya][$xa];
            }
        }
    }
}

$best = array_fill(0, $n * $n, $map[0][0] + $jumps[0][$lastPosition]); //We start with the value of direct jump from start to end
$toCheck = [[0, $map[0][0]]]; //We start exploring at 0;0

while(count($toCheck)) {
    [$position, $cost] = array_pop($toCheck);

    //We can jump to any positions
    for($i = 1; $i < $n * $n; ++$i) {
        if($i == $position) continue; //No point in moving to the current place

        $moveCost = $cost + $jumps[$position][$i]; //The cost of reaching the new positions

        //This move is only valid if we haven't reached the position with a lower cost already
        if($moveCost < $best[$i] && $moveCost < $best[$lastPosition]) {
            $best[$i] = $moveCost;
            $toCheck[] =  [$i, $moveCost];
        } 
    }
}

echo $best[$lastPosition] . PHP_EOL;

error_log(var_export(microtime(1) - $start, true));
?>
