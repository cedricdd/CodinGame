<?php

$ships = [[5, 1], [4, 1], [3, 2], [2, 1]];
$alphabet = array_flip(range("A", "J"));

$map = str_repeat(".", 12*12);
$mapFlipped = str_repeat(".", 12*12);

fscanf(STDIN, "%s", $SHOT);
$shotPosition = substr($SHOT, 1) * 12 + $alphabet[$SHOT[0]] + 1;

for ($y = 1; $y <= 10; $y++) {
    fscanf(STDIN, "%s", $line);

    foreach(str_split($line) as $x => $c) {
        if($c == ".") continue;

        $map[$y * 12 + $x + 1] = $c;
        $mapFlipped[($x + 1) * 12 + $y] = $c;
    }
}

error_log(var_export($map, true));
error_log(var_export(str_split($map, 12), true));
error_log(var_export(str_split($mapFlipped, 12), true));

//Sum of all ships should be equal to 17
if(substr_count($map, "+") + substr_count($map, "_") != 17) die("INVALID");

//Check that we all the ship of the right size and they are not touching each others
foreach($ships as [$size, $count]) {
    $regex = "/(?<=\.{" . ($size + 2) . "}.{" . (10 - $size) . "}\.)[\+\_]{" . $size . "}(?=\..{" . (10 - $size) . "}\.{" . ($size + 2) . "})/";
    preg_match_all($regex, $map, $matches);
    preg_match_all($regex, $mapFlipped, $matchesFlipped);
    
    if(count($matches[0]) + count($matchesFlipped[0]) != $count) die("INVALID");
}

if($map[$shotPosition] != "+") $output[] = "MISSED";
else {
    $output[] = "TOUCHE";

    $size = 1;
    $left = 0;
    foreach([1, -1, 12, -12] as $m) {
        $position = $shotPosition;
        while($map[($position += $m)] != ".") {
            if($map[$position] == "+") ++$left;
            ++$size;
        } 
    }

    if($left == 0) $output[] = "COULE $size";

    if(substr_count($map, "+") == 1) $output[] = "THEN LOSE";
}

echo implode(" ", $output) . PHP_EOL;
?>
