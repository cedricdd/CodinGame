<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$line = "";
for ($i = 0; $i < 3; $i++) {
    //We save it as a single line
    $line .= stream_get_line(STDIN, 4 + 1, "\n");
}

error_log(var_export($line, true));

//Switch two character in the line, $b is the postion of the .
function moveKnight($line, $a, $b) {
    $line[$b] = $line[$a];
    $line[$a] = ".";

    return $line;
}

$toCheck = [[$line, 0]];
$bestSolution = PHP_INT_MAX;
$checked = [];
$moves = [
    0 => [5, 7],
    1 => [6, 8],
    2 => [3, 7],
    3 => [2, 8],
    5 => [0, 6],
    6 => [1, 5],
    7 => [0, 2],
    8 => [1, 3],
];

//The center position can't move anywhere, if it's not 5 it's not reachable
if($line[4] != 5) exit("-1");

while(count($toCheck)) {
    list($line, $count) = array_pop($toCheck);

    //We reached the ordered configuration
    if($line == "12345678.") {
        if($bestSolution > $count) {
            $bestSolution = $count;
            continue;
        }
    }

    //Don't re-check a configuration we already checked
    if(isset($checked[$line])) continue;
    else $checked[$line] = 1;

    //No need to continue if we already have a better solution
    if($count >= $bestSolution) continue;

    //Current free postion
    $position = strpos($line, ".");

    //Test for each posible moves based on the free position
    foreach ($moves[$position] as $move) {
        $toCheck[] = [moveKnight($line, $move, $position), $count + 1];
    }
}

echo ($bestSolution == PHP_INT_MAX ? -1 : $bestSolution); 
?>
