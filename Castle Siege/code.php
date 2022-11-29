<?php

fscanf(STDIN, "%d %d", $W, $H);
for ($y = 0; $y < $H; ++$y) {
    $line = trim(fgets(STDIN));

    //Get the positions of the towers & ennemies
    foreach(str_split($line) as $x => $c) {
        if($c == "T") $towers[$y * $W + $x] = [$x, $y];
        elseif(ctype_digit($c)) $ennemies[$y * $W + $x] = [$x, $y, intval($c)];
    }

    $map[] = $line;
}

error_log(var_export("Starting map", true));
error_log(var_export($map, true));

$round = 1;

while(true) {
    foreach($towers as $indexTower => [$towerX, $towerY]) {

        $targetX = -1;
        $targetY = $H;
        $targetDistance = INF;

        //Each towers tries to attack an ennemy
        foreach($ennemies as $indexEnnemy => [$ennemyX, $ennemyY, $health]) {
            //Ennemy is in reach
            if(abs($towerX - $ennemyX) <= 2 && abs($towerY - $ennemyY) <= 2) {
                $distance = abs($towerX - $ennemyX) + abs($towerY - $ennemyY);

                //Does this ennemy have an higher priority
                if($ennemyY < $targetY || ($ennemyY == $targetY && $distance < $targetDistance) || ($ennemyY == $targetY && $distance == $targetDistance && $ennemyX > $targetX)) {
                    $targetX = $ennemyX;
                    $targetY = $ennemyY;
                    $targetDistance = $distance;
                }
            }
        }

        //Tower is attacking an ennemy
        if($targetDistance != INF) {
            $index = $targetY * $W + $targetX;

            if(isset($ennemies[$index]) && --$ennemies[$index][2] == 0) unset($ennemies[$index]);
        }
    }

    //All the ennemies have been killed, we win
    if(count($ennemies) == 0) break;

    //Ennemies are moving NORTH
    foreach($ennemies as $indexEnnemy => [$ennemyX, $ennemyY, $health]) {
        if($ennemyY == 0) die("LOSE $round");

        $newIndex = $indexEnnemy - $W;

        $map[$ennemyY][$ennemyX] = ".";
        unset($ennemies[$indexEnnemy]);

        //If an ennemy moves into a tower it dies
        if(!isset($towers[$newIndex])) {
            $ennemies[$newIndex] = [$ennemyX, $ennemyY - 1, $health];
            $map[$ennemyY - 1][$ennemyX] = $health;
        } 
    }

    error_log(var_export("Map after round " . $round++, true));
    error_log(var_export($map, true));
}

echo "WIN $round" . PHP_EOL;
