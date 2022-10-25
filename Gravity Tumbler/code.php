<?php

fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d", $count);
for ($i = 0; $i < $height; $i++) {
    $line = trim(fgets(STDIN));
    $sum = substr_count($line, "#");
    //We push all the # at the end of the line
    $map[] = str_repeat(".", $width - $sum) . str_repeat("#", $sum);
}

//Result are repeated, we just need to flip the array once if the number of steps is odd
if($count & 1) {
    $rotated = array_fill(0, $width, str_repeat(".", $height));

    for($y = 0; $y < $height; ++$y) {
        for($x = 0; $x < $width; ++$x) {
            $rotated[$x][$y] = $map[$y][$x];
        }
    }

    $map = $rotated;
}

echo implode("\n", $map) . PHP_EOL;
