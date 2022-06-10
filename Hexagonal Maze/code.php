<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $w, $h);
for ($y = 0; $y < $h; $y++) {
    $map[] = stream_get_line(STDIN, 31 + 1, "\n");

    if(($sx = strpos($map[$y], "S")) !== false) $start = [$sx, $y];
}

error_log(var_export($map, true));

//The moves we can makes based on if the line is odd or even
$moves = [
    0 => [[-1, -1], [0, -1], [-1, 0], [1, 0], [-1, 1], [0, 1]],
    1 => [[0, -1], [1, -1], [-1, 0], [1, 0], [0, 1], [1, 1]],
];

$bestScore = $w * $h;
$outputMap = [];
$toCheck = [[$map, 0, $start]];

while(count($toCheck)) {
    list($map, $score, $postition) = array_pop($toCheck);

    //We already have a better path
    if($score >= $bestScore) continue;

    //Check all the position we can move to
    foreach ($moves[$postition[1] % 2] as $move) {
        $ux = ($postition[0] + $move[0] + $w) % $w;
        $uy = ($postition[1] + $move[1] + $h) % $h;

        //We have reached the exit
        if($map[$uy][$ux] == "E") {
            $bestScore = $score;
            $outputMap = $map;
            
            continue;
        }

        //We can move there
        if($map[$uy][$ux] == "_") {
            $updatedMap = $map;
            $updatedMap[$uy][$ux] = ".";

            $toCheck[] = [$updatedMap, $score + 1, [$ux, $uy]];
        }
    }
}

echo implode("\n", $outputMap);
?>
