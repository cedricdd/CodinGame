<?php

fscanf(STDIN, "%d", $W);
fscanf(STDIN, "%d", $H);
for ($i = 0; $i < $H; $i++) {
    $map[] = str_replace(" " , "", trim(fgets(STDIN)));
}

//Add obstacles arround the map so no matter the position of the treasure it will be surrounded by 8 obstacles
$map = str_repeat("1", $W + 2) . implode("", array_map(function($line) {
    return "1" . $line . "1";
}, $map)) . str_repeat("1", $W + 2);

//Find the location of the treasure
preg_match("/111.{" . ($W - 1) . "}101.{" . ($W - 1) . "}111/", $map, $match, PREG_OFFSET_CAPTURE);

//Display the location of the treasure
echo ($match[0][1] % ($W + 2)) . " " . intdiv($match[0][1], $W + 2) . PHP_EOL;
