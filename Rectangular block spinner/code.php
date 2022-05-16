<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $size);
fscanf(STDIN, "%d", $angle);

for ($i = 0; $i < $size; $i++) {
    $lines[] = explode(" ", stream_get_line(STDIN, 1024 + 1, "\n"));
}

for($y=0; $y < count($lines); ++$y) {
    error_log(var_export(implode(' ', $lines[$y]), true));
}

//Function to rotate a square grid 90° to the left
function rotateLeft(&$grid) {
    $rotated = [];
    for($y=0; $y < count($grid); ++$y) {
        for($x=0; $x < count($grid); ++$x) {
            $rotated[count($grid) - 1 - $x][$y] = $grid[$y][$x];
        }
    }

    $grid = $rotated;
}

//The code that print the diagonal requires to rotate an extra 45° that what we want to show
//If angle is 45° we need to rotate 90°
//If angle is 135° we need to rotate 180°
//If angle is 45*X° we need to rotate 45*(X+1)°
for($i = 0; $i < ceil($angle / 90); ++$i) rotateLeft($lines);

$ctr = 0;

while($ctr < (2 * $size) - 1) {

    //We get the spaces to show on the left & right of the characters
    $spaces = str_repeat(" ", abs($size - $ctr - 1));

    $d = [];

    //The first diagonal are all element for which $x + $y == 0
    //The second diagonal are all element for which $x + $y == 1
    //The nth diagonal are all element for which $x + $y == $n - 1
    for($y = ($size - 1); $y >= 0; $y--){      
        for($x = 0; $x < $size; $x++){ 
            if ($x + $y == $ctr){
                $d[] = $lines[$y][$x];
                break;
            }
        }
    }

    echo $spaces . implode(" ", $d) . $spaces . "\n";
    $ctr += 1;
}
?>
