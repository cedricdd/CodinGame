<?php

fscanf(STDIN, "%d", $L);
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $st, $ed);
    $zones[$st] = $ed;
}
$zones[$L] = 1; //We add this to be able to get the last zone missing 

ksort($zones); //Sort by start point ASC

$finished = true;
$st = 0;

foreach($zones as $start => $end) {
    //There's a part not painted
    if($start > $st) {
        echo $st . " " . $start . "\n";
        $finished = false;
    }
    if($end > $st) $st = $end; //The end is lower than current start
}

if($finished) echo "All painted\n";
?>
