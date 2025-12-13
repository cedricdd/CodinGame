<?php

fscanf(STDIN, "%d %d", $N, $M);
fscanf(STDIN, "%d %d", $S, $E);

$links = [];

for ($i = 0; $i < $M; $i++) {
    fscanf(STDIN, "%d %d %d", $A, $B, $T);

    $links[$A][$B] = $T;
    $links[$B][$A] = $T;
}

$step = 1;
$history = [];
$queue = [[$S, INF]];

while($queue) {
    $newQueue = [];

    foreach($queue as [$pos, $blow]) {
        if($blow == $step) continue; //The path burns

        if($pos == $E) exit("" . ($step - 1)); //We have reached the start before the path burns

        if(isset($history[$pos]) && $history[$pos] <= $blow) continue; //We have already reached this position with a best blown up time
        else $history[$pos] = $blow;

        foreach($links[$pos] as $newPos => $T) {
            $newQueue[] = [$newPos, min($T + $step, $blow)];
        }
    }

    $queue = $newQueue;
    ++$step;
}

echo "IMPOSSIBLE" . PHP_EOL;
