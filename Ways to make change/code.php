<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);

error_log(var_export("N " . $N, true)); 

fscanf(STDIN, "%d", $S);
$coins = array_map('intval', explode(" ", fgets(STDIN)));

$memorization = [];

function solve($n, $s) {
    global $memorization, $coins, $S;
    
    //We already know the result, directly return it
    if($n < 0) return 0;
    if($n == 0) return 1;
    if(isset($memorization[$n][$s])) return $memorization[$n][$s];

    $result = 0;

    //Try to add another coin
    for($i = $s; $i < $S; ++$i) {
        //Coin is too big
        if($coins[$i] > $n) break;

        $result += solve($n - $coins[$i], $i);
    }

    //Save the result for later.
    //We need a multidimentional array because permutations are considered duplicate. For 10, 5*1 + 5 & 5 + 5*1 should only be counted once.
    $memorization[$n][$s] = $result;

    return $result;
}

echo solve($N, 0);
?>
