<?php

fscanf(STDIN, "%d", $width);
fscanf(STDIN, "%d", $height);
fscanf(STDIN, "%d", $t);

for ($y = 0; $y < $height; $y++) {
    fscanf(STDIN, "%s", $line);

    $x = 0;
    for($j = 0; $j < strlen($line); ++$j) {
        //Starting position
        if($line[$j] == "V") {
            $px = $x;
            $py = $y;
        }

        //Input is a single line, negative values take 2 characters
        $grid[$y][$x++] = ($line[$j] == "-") ? $line[$j] . $line[++$j] : $line[$j];
    }
}

for($i = 0; $i < $t; ++$i) {
    $x = $px + 1;
    $y = $py + 1;

    //Landing on a thermal value
    if($grid[$y][$x] !== ".") {
        $y -= $grid[$y][$x];
    }

    //Pilot leaves the grid
    if($x < 0 || $x >= $width || $y < 0 || $y >= $height) break;
    else {
        $px = $x;
        $py = $y;
    }
}

echo $px . " " . ($height - $py - 1) . PHP_EOL;
?>
