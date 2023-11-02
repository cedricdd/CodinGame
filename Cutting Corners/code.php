<?php

fscanf(STDIN, "%d %d", $height, $width);
for ($i = 0; $i < $height; $i++) {
    $map[] = str_replace(" ", "", trim(fgets(STDIN)));
}

$sizes = [0, 0, 0, 0];
$symbol = $map[$height >> 1][$width >> 1]; //The symbol that's not the representation of a triangle

//Check triangle, top left, top right, bottom left, bottom right
foreach([[0, 0, 1, 0, -1, 1], [$width - 1, 0, -1, 0, 1, 1], [0, $height - 1, 0, -1, 1, 1], [$width - 1, $height - 1, 0, -1, -1, 1]] as $index => [$x, $y, $xt, $yt, $xm, $ym]) {
    $size = 1;

    while(true) {
        //Check all the positions of this diagonal
        for($i = 0; $i < $size; ++$i) {
            //The triangle has stopped
            if($map[$y + $ym * $i][$x + $xm * $i] === $symbol) {
                $sizes[$index] = $size - 1;
    
                continue 3;
            }
        }
    
        ++$size;
        $x += $xt;
        $y += $yt;
    }
}

echo $sizes[0] . " " . $sizes[1] . PHP_EOL . $sizes[2] . " " . $sizes[3] . PHP_EOL;
