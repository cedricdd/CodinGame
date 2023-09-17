<?php

fscanf(STDIN, "%d", $M); // $M: the amount of motorbikes to control
fscanf(STDIN, "%d", $min); // $V: the minimum amount of motorbikes that must survive
// $L0: L0 to L3 are lanes of the road. A dot character . represents a safe space, a zero 0 represents a hole in the road.
for($i = 0; $i < 4; ++$i) $L[] = strtr(trim(fgets(STDIN)), ["." => "0", "0" => "1"]);

function solve(int $x, array $bikes, int $speed, array $actions = []): array {
    global $L, $min;
    static $history = [];

    $hash = implode("-", $bikes);

    if(isset($history[$x][$speed][$hash])) return $history[$x][$speed][$hash];

    if($x >= strlen($L[0])) return [count($bikes), $actions];

    $result = [0, []];

    //Test each actions 
    foreach([
        'SPEED' => [1, 0, [[$x + 1, $speed + 1]]], //Change in speed, change in line, the part to check for hole
        'JUMP'  => [0, 0, [[$x + $speed, 1]]],
        'SLOW'  => [-1, 0, [[$x + 1, $speed - 1]]],
        'UP'    => [0, -1, [-1 => [$x + 1, $speed], 0 => [$x + 1, $speed - 1]]],
        'DOWN'  => [0, 1, [[$x + 1, $speed - 1], [$x + 1, $speed]]],
    ] as $name => [$speedChange, $lineChange, $check]) {

        if(($newSpeed = $speed + $speedChange) < 1) continue; //We never want to reach a speed of 0

        $newBikes = [];

        foreach($bikes as $i => $bike) {
            foreach($check as $j => [$start, $length]) {
                if($bike + $j < 0 || $bike + $j > 3) continue 2; //Bike is falling off from the bridge

                if(substr($L[$bike + $j], $start, $length) != 0) continue 2; //Bike is falling in a hole
            }

            $newBikes[] = $bike + $lineChange;
        }

        if(count($newBikes) < $min) continue; //Not enough bikes left

        [$bikeLeft, $listActions] = solve($x + $newSpeed, $newBikes, $newSpeed, array_merge($actions, [$name]));

        if($bikeLeft > $result[0]) {
            $result = [$bikeLeft, $listActions];
            
            if($bikeLeft == count($bikes)) break; //All the bikes survive, we can't do better
        }
    }

    return $history[$x][$speed][$hash] = $result;
}

$listActions = [];

while (TRUE) {
    fscanf(STDIN, "%d", $speed);
    for ($i = 0; $i < $M; $i++) {
        fscanf(STDIN, "%d %d %d", $x, $y, $active);

        //Save the bikes
        if($active == 1) $bikes[] = $y;
    }

    if(count($listActions) == 0) [$bikeLeft, $listActions] = solve($x, $bikes, $speed);

    echo (array_shift($listActions) ?? "WAIT") . PHP_EOL;
}
