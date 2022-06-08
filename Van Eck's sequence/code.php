<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $number);
fscanf(STDIN, "%d", $N);

error_log(var_export("First : " . $number . " nth: " . $N, true));

for($i = 0; $i < $N - 1; ++$i) {
    //Already had this number, get the difference, update the position
    if(isset($numbers[$number])) {
        $difference = $i - $numbers[$number];
        $numbers[$number] = $i;
        $number = $difference;
    } //New number, we get a 0, save position
    else {
        $numbers[$number] = $i;
        $number = 0;
    }
}

echo $number . "\n";
?>
