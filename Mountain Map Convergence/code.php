<?php

fscanf(STDIN, "%d", $n);
$inputs = explode(" ", trim(fgets(STDIN)));

$inputs[] = 1; //We add an extra input to finish the last mountain

//Calculate the width & height of the answer grid
$width = -2;
$height = abs(max($inputs) - min($inputs) + 1);

foreach($inputs as $i => $input) {
    $width += 2 + abs(($inputs[$i- 1] ?? 1) - $input);
}

$keys = range((max(0, max($inputs) - 1)) * -1, abs(min(0, min($inputs) - 1)));
$values = array_fill(0, $height, str_repeat(" ", $width));
$grid = array_combine($keys, $values);

//Start position
$x = 0;
$y = 0;

foreach($inputs as $i => $size) {
    //The row we need to reach before we add the peak
    $objective = ($size - 1) * -1;

    while($y != $objective) {
        //We need to move up
        if($y > $objective) $grid[$y--][$x++] = "/"; 
        //We need to move down
        else $grid[++$y][$x++] = "\\"; 
    }

    if($i == $n) break; //Don't draw the peak of the extra input 

    //Adding the peak
    $grid[$y][$x++] = "/"; 
    $grid[$y][$x++] = "\\"; 
}

echo implode("\n", array_map("rtrim", $grid)) ;
