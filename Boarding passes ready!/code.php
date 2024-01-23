<?php

const LETTERS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $info = explode(",", trim(fgets(STDIN)));

    $passengers[$info[1]] = $info[0];
}

while(count($passengers)) {
    $calling = ['L' => [], 'R' => []];

    //We call passengers from back to front 
    for($y = $h; $y > 0; --$y) {
        //Boarding group 1, pick the first passenger still waiting from the left
        for($x = 0; $x < $w >> 1; ++$x) {
            $seatLeft = $y . LETTERS[$x];

            if(isset($passengers[$seatLeft])) {
                $calling['L'][] = $passengers[$seatLeft];
                unset($passengers[$seatLeft]);

                break;
            }
        }

        //Boarding group 2, pick the first passenger still waiting from the right
        for($x = $w - 1; $x >= $w >> 1; --$x) {
            $seatRight = $y . LETTERS[$x];

            if(isset($passengers[$seatRight])) {
                $calling['R'][] = $passengers[$seatRight];
                unset($passengers[$seatRight]);

                break;
            }
        }
    }

    if(count($calling['L'])) echo "Now boarding: " . implode(",", $calling['L']) . PHP_EOL;
    if(count($calling['R'])) echo "Now boarding: " . implode(",", $calling['R']) . PHP_EOL;
}
