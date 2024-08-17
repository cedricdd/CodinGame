<?php

const POSITIONS = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 25 => 11, 50 => 12, 75 => 13, 100 => 14];

$start = microtime(1);

fscanf(STDIN, "%d", $goal);

$hash = str_repeat('0', 15);
$numbers = $hash;

foreach(explode(" ", trim(fgets(STDIN))) as $number) {
    $index = POSITIONS[$number];
    $numbers[$index] = $numbers[$index] + 1; //Get all the numbers we can use

    $hash[$index] = '1';
    $solutions[1][$number][$hash] = 1;
    $hash[$index] = '0';
}

for($i = 1; $i < 6; ++$i) {
    foreach($solutions[$i] as $value1 => $list1) {
        foreach($list1 as $numbersUsed => $filler) {

            for($j = 1; $j <= $i; ++$j) {
                if($i + $j > 6) continue 2; //We don't have enough numbers for that

                foreach($solutions[$j] as $value2 => $list2) {

                    foreach($list2 as $numbersUsed2 => $filler2) {
                        $numbersUsedTotal = $numbersUsed;

                        //Check if we can combine them, do we have enough of each numbers in total
                        for($index = 0; $index < 15; ++$index) {
                            if($numbersUsed2[$index] == '0') continue;

                            if(($numbersUsedTotal[$index] = $numbersUsedTotal[$index] + $numbersUsed2[$index]) > $numbers[$index]) continue 2;
                        }

                        //Addition
                        $solutions[$i + $j][$value1 + $value2][$numbersUsedTotal] = 1;

                        //Multiplication
                        $solutions[$i + $j][$value1 * $value2][$numbersUsedTotal] = 2;

                        //Substraction
                        if($value1 > $value2) $solutions[$i + $j][$value1 - $value2][$numbersUsedTotal] = 3;
                        if($value2 > $value1) $solutions[$i + $j][$value2 - $value1][$numbersUsedTotal] = 4;

                        //Division
                        if($value1 % $value2 == 0) $solutions[$i + $j][$value1 / $value2][$numbersUsedTotal] = 5;
                        if($value2 % $value1 == 0) $solutions[$i + $j][$value2 / $value1][$numbersUsedTotal] = 6;
                    }
                }
            }
        }
    }

    //We have reached the goal
    if(isset($solutions[$i + 1][$goal])) {
        error_log(microtime(1) - $start);
        exit("POSSIBLE" . PHP_EOL . $i);
    }
}

$closest = INF;
//We can't reach the goal, find the closest
foreach($solutions as $values) {
    foreach($values as $value => $filler) {
        if(($difference = abs($goal - $value)) < $closest) $closest = $difference;
    }
}

echo "IMPOSSIBLE" . PHP_EOL . $closest . PHP_EOL;

error_log(microtime(1) - $start);
