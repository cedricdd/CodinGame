<?php

function area(int $x1, int $y1, int $x2, int $y2, int $x3, int $y3):float {
    return abs(($x1 * ($y2 - $y3) + 
                $x2 * ($y3 - $y1) +  
                $x3 * ($y1 - $y2)) / 2.0);
}

function isInside($x1, $y1, $x2, $y2, $x3, $y3, $x, $y):bool { 
     
    /* Calculate area of triangle ABC */
    $A = area($x1, $y1, $x2, $y2, $x3, $y3);
     
    /* Calculate area of triangle PBC */
    $A1 = area($x, $y, $x2, $y2, $x3, $y3);
     
    /* Calculate area of triangle PAC */
    $A2 = area($x1, $y1, $x, $y, $x3, $y3);
     
    /* Calculate area of triangle PAB */
    $A3 = area($x1, $y1, $x2, $y2, $x, $y);
     
    /* Check if sum of A1, A2 and A3 is same as A */
    return ($A == $A1 + $A2 + $A3);
}


fscanf(STDIN, "%d %d", $h, $w);
$style = trim(fgets(STDIN));

$output = array_fill(0, $h, array_fill(0, $w, 1));

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d %d %d %d %d", $x1, $y1, $x2, $y2, $x3, $y3);

    //Toggle all the points inside the triangle
    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            if(isInside($x1, $y1, $x2, $y2, $x3, $y3, $x, $y)) $output[$y][$x] ^= 1;
        }
    }
}

echo implode("\n", array_map(function($line) use ($style) {
    return strtr(implode(($style == "expanded" ? " " : ""), $line), "01", " *");
}, $output)) . PHP_EOL;
