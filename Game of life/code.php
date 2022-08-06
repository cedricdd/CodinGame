<?php

fscanf(STDIN, "%d %d", $width, $height);
for ($i = 0; $i < $height; $i++) {
    $grid[] = trim(fgets(STDIN));
}

$output = $grid;

for($y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x) {

        $neighbors = 0;

        //Checking the eight neighbors of the cell
        for($yn = max(0, $y - 1); $yn < min($height, $y + 2); ++$yn) {
            for($xn = max(0, $x - 1); $xn < min($width, $x + 2); ++$xn) {
                if($x == $xn && $y == $yn) continue; //Skip the cell

                $neighbors += $grid[$yn][$xn];
            }
        }

        //Under-population or over-population
        if($grid[$y][$x] && ($neighbors > 3 || $neighbors < 2)) $output[$y][$x] = 0;
        //Ressurection
        elseif(!$grid[$y][$x] && $neighbors == 3) $output[$y][$x] = 1;
    }
}

echo implode("\n", $output) . PHP_EOL;
?>
