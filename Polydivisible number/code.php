<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$numbers = array_reverse(explode(" ", stream_get_line(STDIN, 100 + 1, "\n")));

error_log(var_export($numbers, true));

//We have to deal with very high numbers, we need to use BC Math Functions
foreach(range(max($numbers) + 1, 36) as $base) {

    $number = 0;
    foreach ($numbers as $i => $value) $number = bcadd($number, bcmul($value, bcpow($base, $i)));

    //Test if it's a polydivisible number
    for($i = 1; $i <= strlen($number); ++$i) {
        if(bcmod(substr($number, 0, $i), $i) != 0) continue 2;   
    }

    echo $base . "\n";
}
?>
