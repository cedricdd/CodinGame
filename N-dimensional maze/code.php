<?php

function getHash(array $dimensions): string {
    global $n, $alphabet;

    $hash = str_repeat(' ', $n);

    foreach($dimensions as $i => $dimension) $hash[$i] = $alphabet[$dimension];

    return $hash;
}

$alphabet = range('A', 'Z');
$alphabetReverse = array_flip($alphabet);


fscanf(STDIN, "%d", $n);

$sizes = explode(',', trim(fgets(STDIN)));

$positions = explode(',', trim(fgets(STDIN)));
$hashPositions = getHash($positions);

$destination = explode(',', trim(fgets(STDIN)));
$hashDestination = getHash($destination);

fscanf(STDIN, "%d", $b);

//Generate all the obstacles
for ($i = 0; $i < $b; $i++) {
    [$start, $end] = explode(" ", trim(fgets(STDIN)));

    $start = explode(',', $start);
    $end = explode(',', $end);
    $current = $start;

    while(true) {
        $obstacles[getHash($current)] = 1;

        for($j = $n - 1; $j >= 0; --$j) {
            if($current[$j] < $end[$j]) {
                $current[$j]++;

                for($k = $j + 1; $k < $n; ++$k) $current[$k] = $start[$k];

                continue 2;
            }
        }

        break;
    }
}

$toCheck = [$hashPositions];
$history = [];
$turns = 0;

while($toCheck) {
    $newCheck = [];

    foreach($toCheck as $hash) {
        if($hash === $hashDestination) exit("$turns"); // We reached the destination

        if(isset($obstacles[$hash])) continue; // Can't move on an obstacle

        if(isset($history[$hash])) continue; // We can reach this position in less turns
        else $history[$hash] = 1;

        for($i = 0; $i < $n; ++$i) {
            $value = $alphabetReverse[$hash[$i]];

            if($value > 0) {
                $hash2 = $hash;
                $hash2[$i] = $alphabet[$value - 1];

                $newCheck[] = $hash2;
            }
            if($value < $sizes[$i] - 1) {
                $hash2 = $hash;
                $hash2[$i] = $alphabet[$value + 1];

                $newCheck[] = $hash2;
            }
        }
    }

    $toCheck = $newCheck;
    ++$turns;
}

echo "NO PATH" . PHP_EOL;
