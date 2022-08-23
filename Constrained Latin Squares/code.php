<?php

$start = microtime(true);

fscanf(STDIN, "%d", $n);

$range = range(1, $n);
$cols = array_fill(0, $n, [array_combine($range, $range), []]); 
$rows = array_fill(0, $n, [array_combine($range, $range), []]); 
$unknowns = [];
$possibleDigits = [];
$neighbors = [];
$counts = [];
$solutions = 0;

for ($y = 0; $y < $n; ++$y) {
    $line = stream_get_line(STDIN, 10 + 1, "\n");

    error_log(var_export($line, true));

    foreach(str_split($line) as $x => $v) {
        //This position is already set
        if($v != 0) {
            unset($cols[$x][0][$v]); //The digit can't be used in the column anymore
            unset($rows[$y][0][$v]); //The digit can't be used in the row anymore
        } //This position is not set 
        else {
            $position = $y * $n + $x;
            $unknowns[$position] = [$x, $y];
            $cols[$x][1][$position] = $position;
            $rows[$y][1][$position] = $position;
        }
    }
}

//Foreach positions where we don't have a set digit we get all the digits that can be used there 
//and the other positions that should be updated when we set a digit to this position. 
foreach($unknowns as $index => [$x, $y]) {
    $possibleDigits[$index] = array_intersect($cols[$x][0], $rows[$y][0]);

    $neighbors[$index] = $cols[$x][1] + $rows[$y][1];
    unset($neighbors[$index][$index]); //No need to try to update yourself

    $counts[$index] = count($possibleDigits[$index]);
}


function solve(array $possibleDigits, array $counts, array $neighbors):void {
    global $solutions;

    //We want to work on the position that has the less possible digits left
    asort($counts);

    foreach($counts as $position => &$value) {
        //Remove info we don't need anymore
        unset($counts[$position]);
        $positionsToUpdate = $neighbors[$position];
        unset($neighbors[$position]);
        $possibleNumbers = $possibleDigits[$position];
        unset($possibleDigits[$position]);

        //Only on digit can be added at this position
        if($value == 1) {
            $number = array_pop($possibleNumbers);

            //The number can't be used in the row & column anymore
            foreach($positionsToUpdate as $toUpdate) {
                //This number was a possiblity for the other position
                if(isset($possibleDigits[$toUpdate][$number])) {
                    unset($possibleDigits[$toUpdate][$number]);
                    if($counts[$toUpdate]-- == 0) return; //We now have a position where no digit can be used => invalid
                }
                unset($neighbors[$toUpdate][$position]);
            }

            continue;
        } else {
            //Several digits can be used at this position
            foreach($possibleNumbers as $number) {
                $possibleDigitsUpdated = $possibleDigits;
                $countsUpdated = $counts;
                $neighborsUpdated = $neighbors;
        
                //The number can't be used in the row & column anymore
                foreach($positionsToUpdate as $toUpdate) {
                    //This number was a possiblity for the other position
                    if(isset($possibleDigitsUpdated[$toUpdate][$number])) {
                        unset($possibleDigitsUpdated[$toUpdate][$number]);
                        if($countsUpdated[$toUpdate]-- == 0) return; //We now have a position where no digit can be used => invalid
                    }
                    unset($neighborsUpdated[$toUpdate][$position]);
                }
        
                solve($possibleDigitsUpdated, $countsUpdated, $neighborsUpdated);
            }
    
            return;
        }
    }

    ++$solutions; //We have successfully placed a digit in every positions
}

solve($possibleDigits, $counts, $neighbors);

echo $solutions . PHP_EOL;

error_log(var_export(microtime(true) - $start, true)); 
?>
