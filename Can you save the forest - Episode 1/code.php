<?php

fscanf(STDIN, "%d", $maxBurnedForest);

//Simulate the turn
function simulateTurn(array $fires, int $indexWater, array $burnt, string $hash): array {
    global $neighbors;
    
    //This fire is extinguish 
    unset($fires[$indexWater]);
    $hash[$indexWater] = '^';
    
    foreach($fires as $indexFire => $count) {
        //Fire keeps evolving
        if($count < 3) {
            $fires[$indexFire]++;
            $hash[$indexFire] = ($count + 1);
        } //Fire spreads
        else {
            unset($fires[$indexFire]);
            $burnt[$indexFire] = 1;
            $hash[$indexFire] = '*';
            
            foreach($neighbors[$indexFire] as $nIndex) {
                if(isset($burnt[$nIndex])) continue; //Position already burnt
                if(isset($fires[$nIndex])) continue; //Position is already burning
                
                $fires[$nIndex] = 1;
                $hash[$nIndex] = '1';
            }
        }
    }
    
    return [$fires, $burnt, $hash];
}

$solutionBurnt = INF;
$solutionActions = [];

while (TRUE) {
    $start = microtime(1);

    $fires = [];
    $map = [];

    for ($y = 0; $y < 10; ++$y) {
        $map[] = trim(fgets(STDIN));
    }

    error_log(var_export($map, true));

    for($y = 0; $y < 10; ++$y) {
        for($x = 0; $x < 10; ++$x) {
            if($map[$y][$x] == ".") continue;

            $index = $y * 10 + $x;

            if(ctype_digit($map[$y][$x])) $fires[$index] = $map[$y][$x]; //There's a fire there

            //Generate the neighbors positions
            if($x > 0 && $map[$y][$x - 1] != ".") $neighbors[$index][] = $index - 1;
            if($x < 9 && $map[$y][$x + 1] != ".") $neighbors[$index][] = $index + 1;
            if($y > 0 && $map[$y - 1][$x] != ".") $neighbors[$index][] = $index - 10;
            if($y < 9 && $map[$y + 1][$x] != ".") $neighbors[$index][] = $index + 10;
        }
    }

    if(count($solutionActions) == 0) {
        $checks = ["....^^.......^^1^......^3^^....^^.^^.^^.^1^^^^^1^^^^3^^^^^3^.^^.^^.^^....^^1^......^3^^.......^^...." => [$fires, [], []]];
 
        $actionIndex = 0;
        
        while(count($checks)) {
            $newChecks = [];
            
            foreach($checks as $hash => [$fires, $burnt, $actions]) {
                //Check what happens if we extinguish the fire at fireIndex
                foreach($fires as $fireIndex => $count) {
                    [$fires2, $burnt2, $hash2] = simulateTurn($fires, $fireIndex, $burnt, $hash);
            
                    $actions[$actionIndex] = $fireIndex;
                    $countBurnt = count($burnt2);
                    $sumFires = array_sum($fires2);
                    
                    if($countBurnt >= $solutionBurnt) continue; //Current solution saves more positions, we can skip
                    
                    if($countBurnt <= $maxBurnedForest) {
                        //All the fires are out
                        if($sumFires == 0) {
                            error_log("We have a solution with $countBurnt");

                            $solutionBurnt = $countBurnt;
                            $solutionActions = $actions;
                        } else $newChecks[$hash2] = [$fires2, $burnt2, $actions, $sumFires];
                    }
                }
            }
            
            ++$actionIndex;

            //Sort by best scores
            uasort($newChecks, function ($a, $b) {
                return $a[3] <=> $b[3];
            });
            
            $checks = array_slice($newChecks, 0, 250); //We only keep the 250 best
        }
    }
    
    $index = array_shift($solutionActions);
    echo ($index % 10) . " " . (intdiv($index, 10)) . PHP_EOL;

    error_log(microtime(1) - $start);
}
