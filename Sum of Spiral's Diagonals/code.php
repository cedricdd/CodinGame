<?php

fscanf(STDIN, "%d", $n);

 function solve(int $n, int $s): int {
    if($n == 1) return $s;
    elseif($n == 0) return 0;
    else {
        $sum = 4 * $s + ($n - 1 ) * 6;
        
        $s= $s+ 4 * ($n - 1);
        $n = $n - 2;

        return $sum + solve($n, $s);
    }
}

echo solve($n, 1);
?>
