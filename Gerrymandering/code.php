<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/
fscanf(STDIN, "%d %d", $w, $h);
for ($y = 0; $y < $h; ++$y) {
    foreach(explode(" ", fgets(STDIN)) as $x => $value) {
        $score[$y + 1][$x + 1] = intval($value);
    }
}

function solve(array &$score, array &$mem, int $w, int $h): int {
    //Use saved info
    if(isset($mem[$h][$w])) return $mem[$h][$w];
    if($h == 0 || $w == 0) return 0;

    $result = $score[$h][$w];

    //Split the rectangle vertically
    for($i = 1; $i <= $w >> 1; ++$i) {
        $result2 = solve($score, $mem, $i, $h) + solve($score, $mem, $w - $i, $h);
        if($result2 > $result) $result = $result2;
    }
    //Split the rectangle horizontally 
    for($i = 1; $i <= $h >> 1; ++$i) {
        $result2 = solve($score, $mem, $w, $i) + solve($score, $mem, $w, $h - $i);
        if($result2 > $result) $result = $result2;
    }

    return $mem[$h][$w] = $result;
} 

$mem = [];
echo solve($score, $mem, $w, $h);
?>
