<?php

//Generate the LR path to a fraction
function getPath(string $input): string {
    [$m, $n] = explode("/", $input);
    $path = "";

    $start = [0, 1];
    $end = [1, 0];
    
    while(true) {
        $mediant = [$start[0] + $end[0], $start[1] + $end[1]];

        if($mediant == [$m, $n]) break; //We have reach our fraction

        //Current mediant is bigger than the fraction, we need to move Left
        if($mediant[0] / $mediant[1] > $m / $n) {
            $path .= "L";
            $end = $mediant;
        } //Current mediant is lower, we need to move Right 
        else {
            $path .= "R";
            $start = $mediant;
        }
    }

    return $path;
}

//Generate the fraction from the LR path
function getFraction(string $path): string {
    $start = [0, 1];
    $end = [1, 0];
    $mediant = [1, 1];

    for($i = 0; $i < strlen($path); ++$i) {
        //With a Left the new upper bound is the mediant
        if($path[$i] == 'L') $end = $mediant;
        //With a Right the new lower bound is the mediant
        else $start = $mediant;

        //Update the mediant
        $mediant = [$start[0] + $end[0], $start[1] + $end[1]];
    }

    return implode("/", $mediant);
}

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $line = trim(fgets(STDIN));

    if(strpos($line, "/") !== false) echo getPath($line) . PHP_EOL;
    else echo getFraction($line) . PHP_EOL;
}
