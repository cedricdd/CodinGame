<?php

fscanf(STDIN, "%d %d", $N, $M);

if($N == 1) exit("0 0");

$connections = [];

for ($i = 0; $i < $M; $i++) {
    fscanf(STDIN, "%d %d %d", $house1, $house2, $cost);

    $connections[] = [$house1, $house2, $cost];
}

//Sort by cost
usort($connections, function($a, $b) {
    return $a[2] <=> $b[2];
});

//We always use the connection with the lowest cost
[$h1, $h2, $cost] = array_shift($connections);

$totalCost = $cost;
$used = ["$h1 $h2 $cost"];
$houses = [$h1 => 1, $h2 => 2];

//Add the house that can be linked to any of the previously linked with the lowest cost
while($connections) {
    foreach($connections as $id => [$h1, $h2, $cost]) {
        if((isset($houses[$h1]) && !isset($houses[$h2])) || (!isset($houses[$h1]) && isset($houses[$h2]))) {
            $totalCost += $cost;
            $used[] = "$h1 $h2 $cost";
            $houses[$h1] = 1;
            $houses[$h2] = 1;
    
            unset($connections[$id]);

            continue 2;
        } elseif(isset($houses[$h1]) && isset($houses[$h2])) unset($connections[$id]);
    }
}

sort($used, SORT_NATURAL); //numerically sorted (on House1, then on House2)

echo count($used) . " " . $totalCost . PHP_EOL;
echo implode(PHP_EOL, $used) . PHP_EOL;
