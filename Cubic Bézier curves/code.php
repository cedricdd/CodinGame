<?php

fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d", $steps);
fscanf(STDIN, "%d %d", $Ax, $Ay);
fscanf(STDIN, "%d %d", $Bx, $By);
fscanf(STDIN, "%d %d", $Cx, $Cy);
fscanf(STDIN, "%d %d", $Dx, $Dy);

$canvas = array_fill(0, $height, "." . str_repeat(" ", $width - 1));

//https://en.wikipedia.org/wiki/B%C3%A9zier_curve
//B(w) = (1-w)³ * P0 + 3 * (1-w)² * w * P1 + 3 * (1-w) * w² * P2 + w³ * P4 
function interpolation($w): array {
    global $Ax, $Ay, $Bx, $By, $Cx, $Cy, $Dx, $Dy;

    return [
        round((((1 - $w)**3) * $Ax) + ((3 * ((1 - $w)**2)) * $w * $Bx) + (3 * (1 - $w) * ($w**2) * $Cx) + (($w**3) * $Dx)),
        round((((1 - $w)**3) * $Ay) + ((3 * ((1 - $w)**2)) * $w * $By) + (3 * (1 - $w) * ($w**2) * $Cy) + (($w**3) * $Dy)),
    ];
}


foreach(range(0, 1, 1 / ($steps - 1)) as $weight) {
    [$X, $Y] = interpolation($weight);

    $canvas[($height - 1 - $Y)][intval($X)] = "#"; //0;0 is at bottom left not top left
}

echo implode("\n", array_map("rtrim", $canvas)) . PHP_EOL;
