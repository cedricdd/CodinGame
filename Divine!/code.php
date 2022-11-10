<?php

//Check if we have an alignments of 3 after an horizontal swapping
function checkSwapH(int $x, int $y, int $digit, string $direction): bool {
    global $grid;

    //The 2 on the top
    if($y > 1 && $grid[$y - 2][$x] == $digit && $grid[$y - 1][$x] == $digit) return true;
    //The one on the top & bottom
    if($y > 0 && $y < 8 && $grid[$y - 1][$x] == $digit && $grid[$y + 1][$x] == $digit) return true;
    //The 2 on the bottom
    if($y < 7 && $grid[$y + 1][$x] == $digit && $grid[$y + 2][$x] == $digit) return true;

    //The 2 on the right
    if($direction == "left" && $x < 7 && $grid[$y][$x + 1] == $digit && $grid[$y][$x + 2] == $digit) return true;
    //The 2 on the left
    if($direction == "right" && $x > 1 && $grid[$y][$x - 1] == $digit && $grid[$y][$x - 2] == $digit) return true;

    return false;
}

//Check if we have an alignments of 3 after an vertival swapping
function checkSwapV(int $x, int $y, int $digit, string $direction): bool {
    global $grid;

    //The 2 on the left
    if($x > 1 && $grid[$y][$x - 2] == $digit && $grid[$y][$x - 1] == $digit) return true;
    //The one of the left & right
    if($x > 0 && $x < 8 && $grid[$y][$x - 1] == $digit && $grid[$y][$x + 1] == $digit) return true;
    //The 2 on the right
    if($x < 7 && $grid[$y][$x + 1] == $digit && $grid[$y][$x + 2] == $digit) return true;

    //The 2 on the top
    if($direction == "up" && $y > 1 && $grid[$y - 1][$x] == $digit && $grid[$y - 2][$x] == $digit) return true;
    //The 2 on the bottom
    if($direction == "down" && $y < 7 && $grid[$y + 1][$x] == $digit && $grid[$y + 2][$x] == $digit) return true;

    return false;
}

for ($i = 0; $i < 9; ++$i) {
    $grid[] = explode(" ", trim(fgets(STDIN)));
}

$swaps = [];

for($y = 0; $y < 9; ++$y) {
    for($x = 0; $x < 9; ++$x) {
        //We can swirch with the one on the right
        if($x < 8) {
            if($grid[$y][$x] != $grid[$y][$x + 1] && (checkSwapH($x + 1, $y, $grid[$y][$x], "left") || checkSwapH($x, $y, $grid[$y][$x + 1], "right"))) {
                $swaps[] = $y . " " . $x . " " . $y . " " . ($x + 1);
            }
        }
        //We can switch with the one on the bottom
        if($y < 8) {
            if($grid[$y + 1][$x] != $grid[$y][$x] && (checkSwapV($x, $y + 1, $grid[$y][$x], "down") || checkSwapV($x, $y, $grid[$y + 1][$x], "up"))) {
                $swaps[] = $y . " " . $x . " " . ($y + 1) . " " . $x;
            }
        }
    }
}

echo count($swaps) . PHP_EOL;
echo implode("\n", $swaps) . PHP_EOL;
