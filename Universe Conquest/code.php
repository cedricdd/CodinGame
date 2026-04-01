<?php

function solve($index, $current, $listAttacked): void {
    global $planets, $result, $toDestroy, $sizeToDestroy;
    static $history = [];

    if($current > $result) return;

    if(isset($history[$index][$listAttacked])) return;
    else $history[$index][$listAttacked] = true;

    for($i = $index; $i < $sizeToDestroy; ++$i) {
        [$p1, $p2] = $toDestroy[$i];

        //One planet already attacked, we can destroy the road
        if(($listAttacked & (1 << $p1)) || ($listAttacked & (1 << $p2))) continue;

        //Attack the cheapest planet first
        if($planets[$p1][1] > $planets[$p2][1]) [$p1, $p2] = [$p2, $p1];

        //We need to attack one of the two planets
        solve($i + 1, $current + $planets[$p1][1], $listAttacked | (1 << $p1));
        solve($i + 1, $current + $planets[$p2][1], $listAttacked | (1 << $p2));

        return;
    }

    $result = $current;
}

fscanf(STDIN, "%d %d", $planetsCount, $hyperspaceRoads);

$planets = [0]; //Indexes for hyperspace are 1-based
$toDestroy = [];

for ($i = 0; $i < $planetsCount; $i++) {
    fscanf(STDIN, "%s %d", $faction, $ships);

    $planets[] = [$faction, $ships];


}
for ($i = 0; $i < $hyperspaceRoads; $i++) {
    fscanf(STDIN, "%d %d", $planet1, $planet2);

    //We only care about the roads linking two planets belonging to different factions
    if($planets[$planet1][0] != $planets[$planet2][0]) {
        $toDestroy[] = [$planet1, $planet2];
    }
}

$sizeToDestroy = count($toDestroy);

if($sizeToDestroy == 0) die("0"); //Easy nothing to do

$result = PHP_INT_MAX;

solve(0, 0, 0);

echo $result . PHP_EOL;
