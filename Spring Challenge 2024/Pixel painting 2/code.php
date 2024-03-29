<?php

/**
 * @param int $n The size of the image
 * @param (string)[] $targetImage The rows of the desired image, from top to bottom
 */
function solve($n, $targetImage) {
    // Write your code here
    $infos = [];
    $actions = [];
    for($x = 0; $x < $n; ++$x) {
        $blanks = [];
        for($y = 0; $y < $n; ++$y) {
            if($targetImage[$y][$x] == ".") $blanks[] = $y;
        }
        $count = count($blanks);
        if($count != $n) $infos[$count][$x] = $blanks;
    }
  
    krsort($infos);
  
    foreach($infos as $count => $list) {
        foreach($list as $x => $filler) $actions[] = "C $x";
        foreach(reset($list) as $y) $actions[] = "R $y";
    }
    return $actions;
}
