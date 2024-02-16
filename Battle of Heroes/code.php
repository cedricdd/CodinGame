<?php

[$name0, $amount0, $health0, $damage0] = explode(";", trim(fgets(STDIN)));
[$name1, $amount1, $health1, $damage1] = explode(";", trim(fgets(STDIN)));

$stack0 = array_fill(0, $amount0, $health0);
$stack1 = array_fill(0, $amount1, $health1);
$round = 0;

while(true) {
    echo "Round " . ++$round . PHP_EOL;

    for($i = 0; $i < 2; ++ $i) {
        $damages = ${"amount" . $i} * ${"damage" . $i};

        echo ${"amount" . $i} . " " . ${"name" . $i} . "(s) attack(s) " . ${"amount" . (($i + 1) % 2)} . " " . ${"name" . (($i + 1) % 2)} . "(s) dealing $damages damage" . PHP_EOL;

        $death = 0;
    
        while(true) {
            if($damages >= reset(${"stack" . (($i + 1) % 2)})) {
                ++$death;
                ${"amount" . (($i + 1) % 2)}--;
                $damages -= array_shift(${"stack" . (($i + 1) % 2)});
            } else {
                ${"stack" . (($i + 1) % 2)}[0] -= $damages;
                break;
            }
    
            if(count(${"stack" . (($i + 1) % 2)}) == 0) break;
        }
    
        echo "$death unit(s) perish" . PHP_EOL;
        echo (($i == 0) ? "----------" : "##########") . PHP_EOL;
    
        if(count(${"stack" . (($i + 1) % 2)}) == 0) {
            echo ${"name" . $i} . " won! " . ${"amount" . $i} . " unit(s) left" . PHP_EOL;
            break 2;
        }
    }
}
