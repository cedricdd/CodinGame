<?php

fscanf(STDIN, "%d %d", $N, $M);
fscanf(STDIN, "%d %d", $S, $E);

$links = [];

for ($i = 0; $i < $M; $i++) {
    fscanf(STDIN, "%d %d %d", $A, $B, $T);

    $links[$A][$B] = $T;
    $links[$B][$A] = $T;
}

$history = [];
$queue = [[$E, 1]];

while($queue) {
    [$pos, $time] = array_shift($queue);

    foreach($links[$pos] as $newPos => $T) {
        if($T <= $time - 1) continue;

        if($newPos == $S) exit("$time");

        if(!isset($history[$newPos])) {
            $queue[] = [$newPos, $time + 1];

            $history[$newPos] = 1;
        }
    }
}

echo "IMPOSSIBLE" . PHP_EOL;
