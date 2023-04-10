<?php

function solve(array $values, int $happiness, int $production): int {
    global $N, $links;

    $index = count($values);

    if($index == $N + 1) return ($happiness >= 0) ? $production : 0; //We have selected a type for each locations

    if($happiness + (($N - $index + 1) * 2) < 0) return 0; //We can't have a positive happiness
    
    //We test the types for the current locations
    foreach ([-1, 0, 1] as $value) {

        $values[$index] = $value;
        $happinessUpdated = $happiness + $value;
        $productionUpdated = $production;
        
        //Check all the links that are complete with the addition of the current location
        foreach($links[$index] as $dest) {
            switch($values[$dest]) {
                case -1:
                    if($value == 0) ++$productionUpdated;
                    elseif($value == 1) --$happinessUpdated;
                    break;
                case 0:
                    if($value == -1) ++$productionUpdated;
                    elseif($value == 1) ++$happinessUpdated;
                    break;
                case 1:
                    if($value == -1) --$happinessUpdated;
                    elseif($value == 0) ++$happinessUpdated;
                    break;
            }
        }

        $results[] = solve($values, $happinessUpdated, $productionUpdated);
    }

    return max($results);
}

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $L);

$links = array_fill(0, $N, []);
for ($i = 0; $i < $L; $i++) {
    [$a, $b] = explode(" ", trim(fgets(STDIN)));
    if($a > $b) $links[$a][] = $b;
    else $links[$b][] = $a;
}

echo solve([0], 0, 0) . PHP_EOL;
