<?php

fscanf(STDIN, "%d %d", $S, $M);
$maxClients = array_map("intval", explode(" ", trim(fgets(STDIN))));
$services = array_fill(0, $S, 0);

for ($i = 0; $i < $M; $i++) {
    $clients = array_map("intval", explode(" ", trim(fgets(STDIN))));
    $answer = [];

    foreach($clients as $index => $count) {
        $instance = ceil($count / $maxClients[$index]);

        $answer[] = $instance - $services[$index];
        $services[$index] = $instance;
    }

    echo implode(" ", $answer) . PHP_EOL;
}
