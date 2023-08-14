<?php

const INDEXES = [
    "R"  => [[0, 1, 2], [3, 4, 5], [6, 7, 8]],
    "C"  => [[0, 3, 6], [1, 4, 7], [2, 5, 8]],
    "\\" => [1 => [0, 4, 8]],
    "/"  => [1 => [2, 4, 6]],
];

//There are only 8 solutions for 3x3
$solutions = [
    [8, 1, 6, 3, 5, 7, 4, 9, 2],
    [6, 1, 8, 7, 5, 3, 2, 9, 4],
    [4, 9, 2, 3, 5, 7, 8, 1, 6],
    [2, 9, 4, 7, 5, 3, 6, 1, 8],
    [8, 3, 4, 1, 5, 9, 6, 7, 2],
    [4, 3, 8, 9, 5, 1, 2, 7, 6],
    [6, 7, 2, 1, 5, 9, 8, 3, 4],
    [2, 7, 6, 9, 5, 1, 4, 3, 8],
];

for ($n = trim(fgets(STDIN)); $n--;) {
    $input = trim(fgets(STDIN));

    //We are given a position
    if(preg_match("/([0-9]) on ([0-9]),([0-9])/", $input, $matches)) {
        $index = $matches[3] * 3 + $matches[2];

        foreach($solutions as $i => $solution) {
            if($solution[$index] != $matches[1]) unset($solutions[$i]);
        }
    } //We are given a row, col or diagonal
    else {
        preg_match("/([0-9]) on (.)([0-9])/", $input, $matches);

        foreach($solutions as $i => $solution) {
            foreach(INDEXES[$matches[2]][$matches[3]] as $index) {
                if($solution[$index] == $matches[1]) continue 2;
            }

            unset($solutions[$i]);
        }
    }

    //Show the count of remaining solutions
    echo (count($solutions) ? count($solutions) : "NO SOLUTIONS!") . PHP_EOL;

    //Only one solution, show it
    if(count($solutions) == 1) echo implode("\n", array_map(function($line) {
        return implode(" ", $line);
    }, array_chunk(end($solutions), 3))) . PHP_EOL;
}
