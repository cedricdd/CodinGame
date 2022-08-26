<?php

const DIRECTIONS = [[-1, -1], [0, -1], [1, -1], [-1, 0], [1, 0], [-1, 1], [0, 1], [1, 1]];
const GROUND_SPEED = ["G" => [2, 1], "W" => [2, 1], "M" => [4, 2], "S" => [6, 3]];

$startTime = microtime(true);

fscanf(STDIN, "%d %d %d", $W, $H, $N);
fscanf(STDIN, "%s", $quest);

$map = "";

for ($i = 0; $i < $H; $i++) {
    $map .= stream_get_line(STDIN, 100 + 1, "\n");
}
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %d %d", $k, $x, $y);

    $position = $y * $W + $x;
    
    if($k == "HOUSE") {
        $start = $position;
    } elseif($k == "WIZARD") {
        $wizardTower = [$x, $y];
    }

    $pointOfInterest[$position] = $k;
}

$wizardDestination = null;
$wizardDistance = INF;

//Find where the wizard is gonna teleport you
if(isset($wizardTower)) {
    foreach($pointOfInterest as $position => $type) {
        if($type != "WIZARD") {
            $px = $position % $W;
            $py = intdiv($position, $W);

            $distance = abs($wizardTower[0] - $px) + abs($wizardTower[1] - $py);
            if($distance < $wizardDistance) {
                $wizardDistance = $distance;
                $wizardDestination = $position;
            }
        }
    }
}

//Pre-compute the moves for each positions
for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        $position = $y * $W + $x;
        
        foreach(DIRECTIONS as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H && $map[$yu * $W + $xu] != "R") {
                $moves[$y * $W + $x][] = $yu * $W + $xu;
            }
        }
    }
}

const HORSE_VALUE = 1; //001
const ARMOR_VALUE = 2; //010
const RUST_VALUE = 5;  //101
const QUEST_VALUE = 4; //111

$state = 0;
$history = [];
$quickest = 100; //Number of days is constrainted to 100
$days = 0;
$toCheck = array_fill(0, 100, []);
$toCheck[0] = [[$start, $state, $pointOfInterest]];

while(true) {
    //Test all the positions we can reach in $days days
    while(count($toCheck[$days])) {
        [$position, $state, $pointOfInterest] = array_pop($toCheck[$days]);

        $updatedDays = $days;
        $ground = $map[$position];
        $history[$position][$state] = 1;

        //We are on at a point of interest
        if(isset($pointOfInterest[$position])) {
            $type = $pointOfInterest[$position];
    
            //Wizard is teleporting us to the closest POI
            if($type == "WIZARD") {
                ++$updatedDays;
                $position = $wizardDestination;
                $type = $pointOfInterest[$position];
            }
    
            //We are at the castle and the quest is done
            if($type == "CASTLE" && $state & QUEST_VALUE) {
                die("$days");
            } 
            //At one of the possible quest location
            elseif($type == "PRINCESS" || $type == "DRAGON" || $type == "TREASURE") {
                $pointOfInterest[$position] = "COMPLETED";
                if($quest == $type) $state |= QUEST_VALUE;
                $updatedDays += ($state & ARMOR_VALUE) ? 1 : 3;
            } //Getting an horse
            elseif($type == "STABLE") {
                $state |= HORSE_VALUE;
            } //Getting an armor 
            elseif($type == "BLACKSMITH") {
                $state |= ARMOR_VALUE;
            } 
    
            ++$updatedDays;
        }
        //No POI, just increase traveling time
        else $updatedDays += GROUND_SPEED[$ground][$state & HORSE_VALUE];

        if($ground == "W") $state &= RUST_VALUE; //Armor is now rusted
     
        //All the destination we can reach from current position
        foreach($moves[$position] as $destination) {
            if(!isset($history[$destination][$state]) && !($state & HORSE_VALUE && $map[$destination] == "M")) {
                $toCheck[$updatedDays][] = [$destination, $state, $pointOfInterest];
            }
        }
    }
 
    $days++;
}
?>
