<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

for ($y = 0; $y < 9; ++$y) {
    foreach(explode(" ", fgets(STDIN)) as $x => $number) {

        $number = intval($number);

        if(isset($checkR[$y][$number - 1])) exit("false");
        else $checkR[$y][$number - 1] = 1;

        if(isset($checkC[$x][$number - 1])) exit("false");
        else $checkC[$x][$number - 1] = 1;

        if(isset($checkS[intdiv($x, 3) + (intdiv($y, 3) * 3 )][$number - 1])) exit("false");
        else $checkS[intdiv($x, 3) + (intdiv($y, 3) * 3 )][$number - 1] = 1;
    }
}

echo("true\n");
?>
