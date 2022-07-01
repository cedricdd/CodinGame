<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$f = [];
$b = [];
$start = 1;
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $input = stream_get_line(STDIN, 8 + 1, "\n");
    
    if(strpos($input, "Fizz") !== false) $f[] = $i;
    if(strpos($input, "Buzz") !== false) $b[] = $i;
    if(intval($input) != 0) $start = $input - $i;
}

if(count($f) > 1) $f = $f[1] - $f[0]; //Periodicity between 2 occurences
else $f = $f[0] + $start; //Only 1 occurence, position + start

if(count($b) > 1) $b = $b[1] - $b[0]; //Periodicity between 2 occurences
else $b = $b[0] + $start; //Only 1 occurence, position + start

echo $f . " " . $b;
?>
