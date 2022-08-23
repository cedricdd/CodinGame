<?php

CONST TRIOMINOES = [
    1 => [[4, 2], [5, 2], [3, 3]],
    2 => [[1, 2], [2, 2], [3, 3]],
    4 => [[3, 1], [4, 2], [5, 2]],
    8 => [[3, 1], [1, 2], [2, 2]],  
];

fscanf(STDIN, "%d", $n);
$size = 2 ** $n;
$grid = array_fill(0, $size, array_fill(0, $size, 0));
$output = [];
for($y = 0; $y < $size * 2 + 1; ++$y) {
    if($y & 1) $output[] = str_repeat("|  ", $size) . "|";
    else $output[] = str_repeat("+--", $size) . "+";
}

fscanf(STDIN, "%d %d", $x, $y);
$grid[$y][$x] = 1;
$output[$y * 2 + 1][$x * 3 + 1] = "#";
$output[$y * 2 + 1][$x * 3 + 2] = "#";

$checked = [];

function solve(int $startX, int $startY, int $size): bool {
    global $output, $grid, $checked;

    //We are working on a bigger part than a 2x2, decomposing
    if($size > 2) {
        $centerX = $startX + ($size / 2);
        $centerY = $startY + ($size / 2);

        //Until we found all the L-triominoes
        do {
            $finished = true;

            //Center
            $finished &= solve($centerX - 1, $centerY - 1, 2);
            //Top Left
            $finished &= solve($startX, $startY, $size / 2);
            //Bottom Left
            $finished &= solve($startX, $centerY, $size / 2);
            //Top Right
            $finished &= solve($centerX, $startY, $size / 2);
            //Bottom right
            $finished &= solve($centerX, $centerY, $size / 2);
        } while(!$finished);
        
    } //Checking a 2x2 part of the grid
    else {
        if(isset($checked[$startY][$startX])) return true; //Already found the L-triominoes

        $value = $grid[$startY][$startX] + $grid[$startY][$startX + 1] * 2 + $grid[$startY + 1][$startX] * 4 + $grid[$startY + 1][$startX + 1] * 8;

        if($value == 0) return false; //Currently no holes

        $checked[$startY][$startX] = 1;

        //With each L-triominoes we have to remove 3 characters from the output
        foreach(TRIOMINOES[$value] as [$xm, $ym]) {
            $output[$startY * 2 + $ym][$startX * 3 + $xm] = " ";
        }

        //The 4 positions are now holes
        $grid[$startY][$startX] = $grid[$startY][$startX + 1] = $grid[$startY + 1][$startX] = $grid[$startY + 1][$startX + 1] = 1; 
    }

    return true;
}
 
//We start at the 2x2 containing the initial hole and then 4x4, 8x8, ...
for($i = 1; $i <= $n; ++$i) {
    $startX = intdiv($x, 2 ** $i) * (2 ** $i);
    $startY = intdiv($y, 2 ** $i) * (2 ** $i); 
    solve($startX, $startY, 2 ** $i);
 }

echo implode("\n", $output) . PHP_EOL;
?>
