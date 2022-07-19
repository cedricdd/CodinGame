<?php

$robbers = [];
$vaults = [];

fscanf(STDIN, "%d", $R);
fscanf(STDIN, "%d", $V);
for ($i = 0; $i < $V; $i++) {
    fscanf(STDIN, "%d %d", $C, $N);
    
    //Distribute the vaults to the robbers and save them if there are not enough robbers
    if($i < $R) $robbers[] = 10 ** $N * 5 ** ($C - $N);
    else $vaults[] = 10 ** $N * 5 ** ($C - $N);
}

$totalTime = 0;

while(true) {
 
    //We give the next job to the robber with the lowest time
    rsort($robbers);
    $key = array_key_last($robbers);

    //No vaults left to open
    if(empty($vaults)) {
        //Just add the biggest time left to the total
        $totalTime += max($robbers);
        break;
    } else {
        //Add the time to the total
        $time = end($robbers);
        $totalTime += $time;

        //Decrement the time of all the robber by the time added on the total
        $robbers = array_map(function($robber) use ($time) {
            return $robber - $time;
        }, $robbers);

        //Give the next vault to the robber
        $robbers[$key] = array_shift($vaults);
    }
}

echo $totalTime . "\n";
?>
