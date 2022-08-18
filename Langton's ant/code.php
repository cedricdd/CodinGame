<?php

const DIR = ["N" => 0, "W" => 1, "S" => 2, "E" => 3];

fscanf(STDIN, "%d %d", $W, $H);
fscanf(STDIN, "%d %d", $x, $y);
fscanf(STDIN, "%s", $direction);
fscanf(STDIN, "%d", $T);
for ($i = 0; $i < $H; $i++) {
    $grid[] = stream_get_line(STDIN, 30 + 1, "\n");
}

$d = DIR[$direction]; //Direction of the ant

for($i = 0; $i < $T; ++$i) {
    if($grid[$y][$x] == "#") {
        $grid[$y][$x] = ".";
        $d = ($d - 1 + 4) % 4;  
    } else {
        $grid[$y][$x] = "#";
        $d = ($d + 1) % 4;  
    }

    //Move 1 square
    switch($d) {
        case 0: --$y; break;
        case 2: ++$y; break;
        case 1: --$x; break;
        case 3: ++$x; break;
    }
}

echo implode("\n", $grid) . PHP_EOL;
?>
