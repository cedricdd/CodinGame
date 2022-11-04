<?php

function getCommand(array &$commands) : array {
    preg_match("/([0-9]+)([A-Z])/", array_shift($commands), $matches);
    return [$matches[1], $matches[2]];
}

fscanf(STDIN, "%d", $N);
$commands = explode(";", trim(fgets(STDIN)));

$position = array_shift($commands) - 1;
$count = 0;

for ($i = 0; $i < $N; ++$i) {
    [$occ, $pattern] = explode(";", trim(fgets(STDIN)));

    for($j = 0; $j < $occ; ++$j) {
        if($count == 0) [$count, $direction] = getCommand($commands);
        $line = $pattern;
        
        if($direction == "L") $position--;
        if($direction == "R") $position++;
        $line[$position] = "#";
        $count--;
        
        echo $line . PHP_EOL;
    }
}
