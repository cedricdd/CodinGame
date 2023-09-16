<?php

$positions = ["a" => [], "A" => [], "b" => [], "B" => []];

for ($y = 0; $y < 15; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if($c == "#" || $c == ".") continue;
        else $positions[$c][] = [$x, $y];
    }
}

$offside1 = 0;
$offside2 = 0;
if(isset($positions["o"])) {
    $attacking = "A";
    $ball = $positions["o"][0];
} else {
    $attacking = "B";
    $ball = $positions["O"][0];
}

//We are not in a throw-in
if($ball[0] != 0 && $ball[0] != 50 && $ball[1] != 0 && $ball[1] != 14 && !($ball[0] == 25 && $ball[7])) {

    //Find the position where the offside starts
    if($attacking == "A") {
        usort($positions["b"], function($a, $b) {
            return $a[0] <=> $b[0];
        });

        $check = min($positions["b"][1][0], $ball[0], 25);
    } else {
        usort($positions["a"], function($a, $b) {
            return $b[0] <=> $a[0];
        });

        $check = max($positions["a"][1][0], $ball[0], 25);
    }

    //Inactive players offside
    foreach(($attacking == "A" ? $positions["a"] : $positions["b"]) as [$x, $y]) {
        if(($attacking == "A" && $x < $check) || ($attacking == "B" && $x > $check)) ++$offside1;
    } //Active players offside
    foreach(($attacking == "A" ? $positions["A"] : $positions["B"]) as [$x, $y]) {
        if(($attacking == "A" && $x < $check) || ($attacking == "B" && $x > $check)) ++$offside2;
    }
} 

echo (($offside = $offside1 + $offside2) ? "$offside player(s) in an offside position." : "No player in an offside position.") . PHP_EOL;
echo ($offside2 ? "VAR: OFFSIDE!" : "VAR: ONSIDE!") . PHP_EOL;
