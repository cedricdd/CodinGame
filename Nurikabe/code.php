<?php


$start = microtime(1);

fscanf(STDIN, "%d", $N);

$grid = "";
$water = $N * $N;

for($y = 0; $y < $N; ++$y) {
    $line = trim(fgets(STDIN));

    foreach(str_split($line) as $x => $c) {
        $index = $y * $N + $x;

        if($x > 0) $neighbors[$index][] = $index - 1;
        if($x < $N - 1) $neighbors[$index][] = $index + 1;
        if($y > 0) $neighbors[$index][] = $index - $N;
        if($y < $N - 1) $neighbors[$index][] = $index + $N;

        if($c != ".") {
            $clues[$index] = $c;
            $water -= $c;
        }
    }

    $grid .= $line;
}

$islandsToFind = count($clues);
$counts = [];
$islands = [];
$indexIsland = 0;
$positions = array_fill(0, $N * $N, []);

function arrayInsertSorted(array $input, int $position): array {
    $result = [];
    $inserted = false;

    foreach($input as $index => $value) {
        if(!$inserted && $index > $position) {
            $result += [$position => 1];
            $inserted = true;
        }

        $result[$index] = 1;
    }

    if(!$inserted) $result += [$position => 1];

    return $result;
}

function getIslands(int $index, int $count): array {

    global $neighbors, $grid;
    $islands = [[$index => 1]];
    $forbidden = [$index => 1];

    for($i = 1; $i < $count; ++$i) {
        $updatedIslands = [];

        foreach($islands as $islandIndex => $islandPositions) {
            foreach($islandPositions as $position => $filler) {
                foreach($neighbors[$position] as $neighbor) {
                    if(isset($forbidden[$neighbor]) || isset($islandPositions[$neighbor])) continue; //This position can't be used for this island
                    if(ctype_digit($grid[$neighbor])) {
                        $forbidden[$neighbor] = 1;
                        continue; //A clue can't be part of the island
                    }

                    foreach($neighbors[$neighbor] as $check) {
                        if(ctype_digit($grid[$check]) && !isset($islandPositions[$check])) {
                            $forbidden[$neighbor] = 1;
                            continue 2; //This is the neighbor of another island, it needs to be water
                        }
                    }

                    //error_log(var_export($islandPositions, true));
                    $updatedIsland = arrayInsertSorted($islandPositions, $neighbor);
                    //error_log(var_export($updatedIsland, true));

                    $updatedIslands[implode("-", array_keys($updatedIsland))] = $updatedIsland;
                }
            }
        }

        $islands = $updatedIslands;
    }

    return $islands;
}

$test = 0;

foreach($clues as $index => $count) {
    $possibleIslands = getIslands($index, $count);
    $possibleIslandsCount = count($possibleIslands);

    $test += $possibleIslandsCount;

    //error_log(var_export($possibleIslands, true));

    if($possibleIslandsCount == 1) {
        $islandPositions = array_pop($possibleIslands);

        foreach($islandPositions as $position => $filler) {
            unset($positions[$position]);
            unset($counts[$position]);
            $grid[$position] = $count;
        }

        --$islandsToFind;
    } else {
        foreach($possibleIslands as $islandPositions) {
            foreach($islandPositions as $position => $filler) {
                $positions[$position][$index][] = $indexIsland;

                foreach($neighbors[$position] as $neighbor) {
                    $islandsWithWater[$indexIsland][$neighbor] = 1;
                }
            }

            $islands[$index][$indexIsland++] = $islandPositions;
        }

        $counts[$index] = $possibleIslandsCount;
    }
}

error_log(var_export(str_split($grid, $N), true));
//error_log(var_export($clues, true));
//error_log(var_export($counts, true));
//exit();

function checkWater(string $grid) {
    global $water, $neighbors, $N;

    $startPosition = strpos($grid, ".");
    $toCheck = [$startPosition];
    $count = 0;
    $list = [];

    //error_log(var_export($grid, true));
    //error_log(var_export("starting at $startPosition", true));

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as $position) {
            if(isset($list[$position])) continue;
            else $list[$position] = 1;

            ++$count;

            foreach($neighbors[$position] as $neighbor) {
                if(!ctype_digit($grid[$neighbor])) $newCheck[] = $neighbor;
            }
        }

        $toCheck = $newCheck;
    }

    if($count == $water) {
        //error_log(var_export(str_split($grid, $N), true));
        error_log(var_export("found one", true));
        //exit();
    } else {
        //error_log(var_export("water doesn't match $count != $water", true));
    }
}

function solve(array $islands, array $counts, string $grid, int $islandsToFind) {
    global $islandsWithWater, $positions, $clues, $N;

    if($islandsToFind == 0) {
        checkWater($grid);
        //error_log(var_export(str_split($grid, $N), true));
        //exit();
        //error_log("found one");
        return;
    }

    $min = INF;
    $clue = 0;
    foreach($counts as $index => $value) {
        if($value > 0 && $value < $min) {
            $clue = $index;
            $min = $value;

            if($value == 1) break;
        }
    }

    //error_log(var_export("working on clue $clue", true));
    //error_log(var_export($islands[$clue], true));
    
    foreach($islands[$clue] as $islandIndex => $island) {

        $islands2 = $islands;
        $counts2 = $counts;
        $grid2 = $grid;

        unset($islands2[$clue]);
        unset($counts2[$clue]);

        //error_log("using island #$islandIndex " . implode("-", array_keys($island)));

        foreach($island as $islandPosition => $filler) {
            $grid2[$islandPosition] = $clues[$clue];
        }

        foreach($islandsWithWater[$islandIndex] as $islandPosition => $filler) {

            //error_log("$islandPosition");

            foreach($positions[$islandPosition] as $clueIndex2 => $listIslands) {
                if(!isset($counts2[$clueIndex2])) continue;

                foreach($listIslands as $indexToRemove) {
                    //error_log("island #$indexToRemove for clue #$clueIndex2 can't be used anymore because of pos $islandPosition");

                    if(--$counts2[$clueIndex2] == 0) continue 4;

                    unset($islands2[$clueIndex2][$indexToRemove]);
                }
            }
        }

        solve($islands2, $counts2, $grid2, $islandsToFind - 1);

    }
}

solve($islands, $counts, $grid, $islandsToFind);

error_log(microtime(1) - $start);
