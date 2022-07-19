<?php

function checkPosition(array $grid, int $xs, int $ys): int {

    $captured = 0;
    $grid[$ys][$xs] = "."; //Don't hit yourself

    foreach(["U", "L", "D", "R"] as $move) {

        $steps = 0; //We do a full loop with 24 steps
        $loop = 0;
        $x = $xs;
        $y = $ys;

        while(true) {
            switch($move) {
                case "U": --$y; break;
                case "L": --$x; break;
                case "D": ++$y; break;
                case "R": ++$x; break;
            }

            ++$steps;

            if($y < 0) {
                switch($x) {
                    case 1: $x = 0; $y = 1; ++$loop; $move = "R"; break;
                    case 2: $x = 0; $y = 2; ++$loop; $move = "R"; break;
                    case 3: $x = 5; $y = 2; ++$loop; $move = "L"; break;
                    case 4: $x = 5; $y = 1; ++$loop; $move = "L"; break;
                    default: break 2;
                }
            } elseif($y > 5) {
                switch($x) {
                    case 1: $x = 0; $y = 4; ++$loop; $move = "R"; break;
                    case 2: $x = 0; $y = 3; ++$loop; $move = "R"; break;
                    case 3: $x = 5; $y = 3; ++$loop; $move = "L"; break;
                    case 4: $x = 5; $y = 4; ++$loop; $move = "L"; break;
                    default: break 2;
                }   
            } elseif($x < 0) {
                switch($y) {
                    case 1: $x = 1; $y = 0; ++$loop; $move = "D"; break;
                    case 2: $x = 2; $y = 0; ++$loop; $move = "D"; break;
                    case 3: $x = 2; $y = 5; ++$loop; $move = "U"; break;
                    case 4: $x = 1; $y = 5; ++$loop; $move = "U"; break;
                    default: break 2;
                }
            } elseif($x > 5) {
                switch($y) {
                    case 1: $x = 4; $y = 0; ++$loop; $move = "D"; break;
                    case 2: $x = 3; $y = 0; ++$loop; $move = "D"; break;
                    case 3: $x = 3; $y = 5; ++$loop; $move = "U"; break;
                    case 4: $x = 4; $y = 5; ++$loop; $move = "U"; break;
                    default: break 2;
                }
            }
            if($grid[$y][$x] != "." || $steps > 24) {
                if($grid[$y][$x] == "O" && $loop) ++$captured;
                break;
            }
        }
    }

    return $captured;
}

$start= microtime(true);

for ($i = 0; $i < 6; $i++) {
    fscanf(STDIN, "%s", $grid[]);
}

$captured = 0;
for($y = 0; $y < 6; ++$y) {
    for($x = 0; $x < 6; ++$x) {
        if($grid[$y][$x] == "X") {
            $captured += checkPosition($grid, $x, $y);
        }
    }
}

echo $captured;

error_log(var_export("\n" . (microtime(true) - $start), true));
?>
