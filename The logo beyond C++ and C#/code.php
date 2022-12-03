<?php

fscanf(STDIN, "%d", $size);
fscanf(STDIN, "%d", $thickness);
fscanf(STDIN, "%d", $height);

for ($i = 0; $i < $height; $i++) {
    $logo[] = str_split(rtrim(fgets(STDIN)));
}

$width = max(array_map('count', $logo));
$spaceSize = ($size - $thickness) >> 1;

$grid = array_fill(0, $size * $height, str_repeat(" ", $width * $size));

foreach($logo as $y => $line) {
    foreach($line as $x => $character) {
        if($character == "+") {
            for($i = 0; $i < $thickness; ++$i) {
                //Top border if there's nothing directly above
                if(($logo[$y - 1][$x] ?? " ") != "+") $grid[$y * $size][$x * $size + $spaceSize + $i] = "+";
                //Bottom border if there's nothing directly below
                if(($logo[$y + 1][$x] ?? " ") != "+") $grid[($y + 1) * $size - 1][$x * $size + $spaceSize + $i] = "+";
                //Left border if there's nothing directly left
                if(($logo[$y][$x - 1] ?? " ") != "+") $grid[$y * $size + $spaceSize + $i][$x * $size] = "+";
                //Right border if there's nothing directly right
                if(($logo[$y][$x + 1] ?? " ") != "+") $grid[$y * $size + $spaceSize + $i][($x + 1) * $size - 1] = "+";
            }
            
            //The parts between the borders to from the + shape
            for($i = 0; $i <= $spaceSize; ++$i) {
                $grid[$y * $size + $i][$x * $size + $spaceSize] = "+";
                $grid[$y * $size + $i][$x * $size + $spaceSize + $thickness - 1] = "+";

                $grid[($y + 1) * $size - 1 - $i][$x * $size + $spaceSize] = "+";
                $grid[($y + 1) * $size - 1 - $i][$x * $size + $spaceSize + $thickness - 1] = "+";

                $grid[$y * $size + $spaceSize][$x * $size + $i] = "+";
                $grid[$y * $size + $spaceSize][($x + 1) * $size - $spaceSize - 1 + $i] = "+";

                $grid[($y + 1) * $size - $spaceSize - 1][$x * $size + $i] = "+";
                $grid[($y + 1) * $size - $spaceSize - 1][($x + 1) * $size - $spaceSize - 1 + $i] = "+";
            }
        }
    }
}

echo implode("\n", array_map("rtrim", $grid)) . PHP_EOL;
