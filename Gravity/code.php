<?php

fscanf(STDIN, "%d %d", $width, $height);

$grid = array_fill(0, $height, str_repeat(".", $width)); //Initially the grid is empty
$idx = array_fill(0, $width, $height - 1); //One index per column

for ($i = 0; $i < $height; $i++) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        //There's a # in the column $x, add it in the grid
        if($c == "#") $grid[$idx[$x]--][$x] = "#";
    }
}

echo implode("\n", $grid);
?>
