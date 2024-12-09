<?php

[$folds, $cut] = explode("-", trim(fgets(STDIN)));

//The start of the paper
if($cut == "tl") $paper = ["01", "11"];
elseif($cut == "tr") $paper = ["10", "11"];
elseif($cut == "bl") $paper = ["11", "01"];
elseif($cut == "br") $paper = ["11", "10"];

$w = 2;
$h = 2;

//We unfold the paper
foreach(str_split(strrev($folds)) as $fold) {
    //Unfold from left ot the right
    if($fold == 'R') {
        foreach($paper as $i => $line) $paper[$i] = $line . strrev($line);

        $w *= 2;
    } //Unfold from the right to the left
    elseif($fold == 'L') {
        foreach($paper as $i => $line) $paper[$i] = strrev($line) . $line; 

        $w *= 2;
    } //Unfold from the top to the bottom
    elseif($fold == 'B') {
        foreach(array_reverse($paper) as $line) array_push($paper, $line);

        $h *= 2;
    } //Unfold from the bottom to the top
    elseif($fold == 'T') {
        foreach($paper as $line) array_unshift($paper, $line);

        $h *= 2;
    }
}

$cuts = 0;

//Count the number of cuts in the paper
for($x = 1; $x < $w - 1; ++$x) {
    for($y = 1; $y < $h - 1; ++$y) {
        if($paper[$y][$x] == '0' && $paper[$y][$x + 1] == '0' && $paper[$y + 1][$x] == '0' && $paper[$y + 1][$x + 1] == '0') ++$cuts;
    }
}

echo $cuts . PHP_EOL;
