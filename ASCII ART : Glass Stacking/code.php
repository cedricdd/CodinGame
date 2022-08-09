<?php

const GLASS = [" *** "," * * "," * * ","*****",];

fscanf(STDIN, "%d", $N);
$output = [];

for($i = 1;; ++$i) {

    //Each existing rows get 3 extra spaces on both side
    array_walk($output, function(string &$line) {
        $line = str_pad($line, strlen($line) + 6, " ", STR_PAD_BOTH);
    });

    //Add the new line of glasses
    foreach(GLASS as $line) $output[] = implode(" ", array_fill(0, $i, $line));

    if(($N -= $i) < $i + 1) break; //Not enough for the next row
}

echo implode("\n", $output);
?>
