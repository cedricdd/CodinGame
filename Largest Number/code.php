<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $number);
fscanf(STDIN, "%d", $D);

$highest = 0;

//Initial number is divisible by D
if(($number % $D) == 0) $highest = $number;
else {
    for($i = 0; $i < strlen($number); ++$i) {
        for($j = 0; $j < strlen($number); ++$j) {
           
            //Remove up to 2 digit from the number
            $n = str_split(strval($number));
            unset($n[$i]);
            unset($n[$j]);
            $n = intval(implode('', $n));

            //This number is divisible by D and is bigger than current highest
            if($n % $D == 0 && $n > $highest) $highest = $n;
        }
    }
}

echo $highest . "\n";
?>
