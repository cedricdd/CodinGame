<?php

fscanf(STDIN, "%d %d %f %f %f %f %d", $width, $height, $cx, $cy, $ro, $ri, $samples);

//We square the radii
$ri *= $ri;
$ro *= $ro;

$frame = [];

for($y = 0; $y < $height; ++$y) {
    $line = "";

    for($x = 0; $x < $width; ++$x) {

        $inside = 0;

        for($i = 0; $i < $samples; ++$i) {
            for($j = 0; $j < $samples; ++$j) {
                //Calculate the distance, on the x axis each position is only half a unit
                $d = (($x + (($i + 0.5) / $samples) - $cx) / 2) ** 2 + ($y + (($j + 0.5) / $samples) - $cy) ** 2;

                if($ri <= $d && $d <= $ro) ++$inside; //The point is inside the ring
            }
        }

        $ratio = $inside / ($samples ** 2);

        if($ratio < 0.1) $line .= ' ';
        elseif($ratio < 0.2) $line .= '.';
        elseif($ratio < 0.3) $line .= ':';
        elseif($ratio < 0.4) $line .= '-';
        elseif($ratio < 0.5) $line .= '=';
        elseif($ratio < 0.6) $line .= '+';
        elseif($ratio < 0.7) $line .= '*';
        elseif($ratio < 0.8) $line .= '#';
        elseif($ratio < 0.9) $line .= '%';
        else $line .= '@';
    }

    $frame[] = $line;
}

echo '+' . str_repeat('-', $width) . '+' . PHP_EOL;

foreach($frame as $line) echo '|' . $line . "|" . PHP_EOL;

echo '+' . str_repeat('-', $width) . '+' . PHP_EOL;
