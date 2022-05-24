<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $R);
fscanf(STDIN, "%d", $L);

$line = [$R];

for($i = 1; $i < $L; ++$i) {
    $number = $line[0];
    $count = 1;
    $tempLine = [];

    for($j = 1; $j < count($line); ++$j) {
        //Found a new number
        if($line[$j] !== $number) {
            array_push($tempLine, $count, $number);
            
            $number = $line[$j];
            $count = 1;
        } //Another occurence of the same number 
        else {
            ++$count;
        }
    }

    //Add the last info
    $line = array_merge($tempLine, [$count, $number]);
}

echo implode(" ", $line) . "\n";
?>
