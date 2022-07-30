<?php

fscanf(STDIN, "%d %d", $width, $height);

$map = "";
for ($i = 0; $i < $height; $i++) {
    $map .= trim(fgets(STDIN));
}

//Every # that can fall 1 line is moved down  until no # can no longer fall down
while(preg_match_all("/(?=#.{" . ($width - 1) . "}\.)/", $map, $matches, PREG_OFFSET_CAPTURE)) {
    
    foreach($matches[0] as [, $i]) {
        $map[$i] = ".";
        $map[$i + $width] = "#";
    }
}

//All the # are at the bottom of the map, print it
echo implode("\n", str_split($map, $width));
?>
