<?php

// $rows: Number of rows
fscanf(STDIN, "%d", $rows);
// $columns: Number of columns
fscanf(STDIN, "%d", $columns);

while (TRUE) {
    $spaces = [];
    $positions = [];

    for ($i = 0; $i < $rows; $i++) {
        fscanf(STDIN, "%d %d", $xPlayer, $xBoss);

        $positions[] = $xPlayer;

        if(($space = $xBoss - $xPlayer - 1) > 0) $spaces[$i] = $space;
    }

    //Calculmate the current XOR value of the spaces
    $xor = array_reduce($spaces, function($carry, $item) {
        return $carry ^ $item;
    });

    //Winning strategy is to make sure that the xor result of the space left between your token and the boss token on each line is equal to 0
    foreach($spaces as $i => $space) {
        //We test all the moves on this row
        for($d = 0; $d < $space; ++$d) {
            $spaces[$i] = $d;

            //Check if it's a winning move, if the xor is equal to 0 again
            if(($xor ^ $space ^ $d) == 0) {
                echo $i . " " .  ($positions[$i] + ($space - $d)) . PHP_EOL;

                break 2;
            }
        }

        $spaces[$i] = $space;
    }
}
