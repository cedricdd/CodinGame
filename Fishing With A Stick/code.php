<?php

//Find all the positions occupied by the rod
function getRod(array &$lake): array {
    $rod = [];

    $x = strpos($lake[0], "|");
    if($x === false) $x = strpos($lake[0], "C");

    $searching = true;
    $y = 0;
    while($searching) {
        $rod[$y][$x] = 1;
        if($lake[$y][$x] == "C") $searching = false;
        $lake[$y][$x] = ".";
        ++$y;
    }

    return $rod;
}

fscanf(STDIN, "%d", $H);
fscanf(STDIN, "%d", $W);
$currentD = (stream_get_line(STDIN, 5 + 1, "\n") == "LEFT") ? "<" : ">";

for ($y = 0; $y < $H; ++$y) {
    $lake[] = stream_get_line(STDIN, 1024 + 1, "\n");
}

$rod = getRod($lake);

$objects = [];
//Classify everything in the lake and their directions
for ($y = 0; $y < $H; ++$y) {
    for ($x = 0; $x < $W; ++$x) {
        if($lake[$y][$x] == "<" || $lake[$y][$x] == ">") $objects[] = ["F", $x, $y, $lake[$y][$x]]; 
        elseif($lake[$y][$x] != ".") {
            $objects[] = ["G", $x, $y, $currentD];
            $lake[$y][$x] = $currentD;
        }
    }
}

$fishes = 0;
$broken = false;

//Make everything move until the rod breaks of there's nothing left
while(count($objects) && !$broken) {
    $updatedLake = array_fill(0, $H, str_repeat(".", $W));

    foreach ($objects as $i => [$type, &$x, $y, $direction]) {
        if($direction == "<") --$x;
        else ++$x;
 
        //Out of lake
        if($x < 0 || $x == $W) {
            unset($objects[$i]);
            continue;
        }

        //Object hit the rod
        if(isset($rod[$y][$x])) {
            if($type == "F") ++$fishes;
            else $broken = true;

            unset($objects[$i]);
            continue;
        }

        //Object collides with something else
        if(($direction == "<" && ($lake[$y][$x] == ">" || ($x > 0 && $lake[$y][$x - 1] == ">"))) ||
           ($direction == ">" && ($lake[$y][$x] == "<" || ($x < $W - 1 && $lake[$y][$x + 1] == "<")))) {
            unset($objects[$i]);
            continue;
        } else $updatedLake[$y][$x] = $direction;
    }

    $lake = $updatedLake;
}

echo $fishes . PHP_EOL;
?>
