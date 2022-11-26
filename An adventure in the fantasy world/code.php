<?php

const DIRECTION = ["U" => [0, -1], "D" => [0, 1], "L" => [-1, 0], "R" => [1, 0]];

fscanf(STDIN, "%s", $path);
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    [$y, $x, $a, $b] = explode(" ", trim(fgets(STDIN)));

    $poi[$y][$x] = [$a, $b];
}

$x = 0;
$y = 0;
$money = 50;

foreach(str_split($path) as $move) {
    [$xm, $ym] = DIRECTION[$move];

    $x += $xm;
    $y += $ym;

    if(isset($poi[$y][$x])) {
        //We take the money
        if($poi[$y][$x][0] == "money") {
            $money += intval($poi[$y][$x][1]);
            unset($poi[$y][$x]);
        } //We are forced to fight or we can't pay the goblin 
        elseif($poi[$y][$x][1] != "goblin" || $money < 50) {
            die($y . " " . $x . " " .  $money . "G " . $poi[$y][$x][1]);
        } //We have to pay the goblin 
        else $money -= 50;
    }
}

echo "GameClear " . $y . " " . $x . " " .  $money . "G" . PHP_EOL;
