<?php

function generateAffectedPositions(): array {
    $affected = [];

    for($y = 0; $y < 9; ++$y) {
        for($x = 0; $x < 9; ++$x) {
            $index = $y * 9 + $x;

            for($i = 0; $i < 9; ++$i) {
                //The rows that are affected
                $affected[$index][] = $i * 9 + $x;
                //The cols that are affected
                $affected[$index][] = $y * 9 + $i;
            }
        
            //The positions in the same region
            for($y2 = (floor($y / 3) * 3); $y2 < ((floor($y / 3) + 1) * 3); ++$y2) {
                for($x2 = (floor($x / 3) * 3); $x2 < ((floor($x / 3) + 1) * 3); ++$x2) {
                    $affected[$index][] = intval($y2 * 9 + $x2);
                }
            }

            $affected[$index] = array_unique($affected[$index]);
        }
    }

    return $affected;
}

function solve(string $grid, array $possibleNumbers, array $cages): void {
    global $cagesMatch, $affectedPositions;

    do {
        $numberFound = false;

        foreach($possibleNumbers as $index => $list) {
            //There are no number left for this position, invalid grid
            if(count($list) == 0) return;

            //There is only only possible number for this position
            elseif(count($list) == 1) {
                $value = array_key_first($list);
                
                $cageName = $cagesMatch[$index];

                //This was the last number to find in the region
                if(count($cages[$cageName][1]) == 1) {
                    if($value != $cages[$cageName][0]) return; //Sum of the cage doesn't match, invalid grid
                    else unset($cages[$cageName]);
                }
                else {
                    if(($cages[$cageName][0] -= $value) <= 0) return; //Update the value of the sum & check if the sum is already too big
                    unset($cages[$cageName][1][$index]); //Update the positions left to find in this cage
                }

                $grid[$index] = $value;

                unset($possibleNumbers[$index]);
                foreach($affectedPositions[$index] as $position) unset($possibleNumbers[$position][$value]);

                $numberFound = true;
            }
        }

        foreach($cages as $name => [$value, $list]) {
            //There only one position in this cage that is still missing
            if(count($list) == 1) {
                $index = array_key_first($list);

                //The value missing to reach the sum of the cage is not a valid value for this position => invalid grid
                if(!isset($possibleNumbers[$index][$value])) return;

                unset($cages[$name]); ///We are done with this cage

                $grid[$index] = $value;

                unset($possibleNumbers[$index]);
                foreach($affectedPositions[$index] as $position) unset($possibleNumbers[$position][$value]);

                $numberFound = true;
            }
        }

    } while($numberFound); //Restart the loop as long as some number have been found

    //There are some positions with multiple possibilites
    if(count($possibleNumbers) > 0) {
        foreach($possibleNumbers as $index => $list) {
            foreach($list as $value => $filler) {
                //Test each values for this position
                $possibleNumbers[$index] = [$value => 1];

                solve($grid, $possibleNumbers, $cages);
            }

            return;
        }
    } 

    //We have found the solution
    echo implode("\n", str_split($grid, 9)) . PHP_EOL;
}

$start = microtime(1);

$numbers = array_flip(range(1, 9)); //We use the index and not the value to be able to directly unset
$possibleNumbers = array_fill(0, 81, $numbers);
$grid = str_repeat("0", 81);
$affectedPositions = generateAffectedPositions();

for ($y = 0; $y < 9; ++$y) {
    fscanf(STDIN, "%s %s", $gridLine, $gridCages);

    for($x = 0; $x < 9; ++$x) {
        $index = $y * 9 + $x;
        $value = intval($gridLine[$x]);

        if($value != 0) {
            $grid[$index] = $value;
            unset($possibleNumbers[$index]); //This position has been set

            foreach($affectedPositions[$index] as $position) unset($possibleNumbers[$position][$value]);
        }

        $name = $gridCages[$x];
        
        //We need to create this cage
        if(!isset($cages[$name])) $cages[$name] = [0, []];
        
        if($value != 0) $cages[$name][0] -= $value; //Update the value left to find in this cage
        else $cages[$name][1][$index] = 1; //Update the # of numbers left to find in this cage
        
        $cagesMatch[$index] = $name; //keep track of which cage is associated with each positions
    }
}

foreach(explode(" ", trim(fgets(STDIN))) as $values) {
    [$name, $value] = explode("=", $values);

    $cages[$name][0] += $value;
}

solve($grid, $possibleNumbers, $cages);

error_log(microtime(1) - $start);
