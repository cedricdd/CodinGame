<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

//For given N total holes, and K test tube, it can be balanced if and only if both K and N-K can be expressed as sum of prime number factors of N.

function primeFactors($n) {
    $factors = [];
    $divisor = 2;
  
    while ($n >= 2) {
      if ($n % $divisor == 0) {
        $factors[$divisor] = 1;
        $n /= $divisor;
      } else {
        $divisor++;
      }
    }
    return $factors;
  }

fscanf(STDIN, "%d", $N);
error_log(var_export("N " . $N, true));

$factors = array_keys(primeFactors($N));

error_log(var_export($factors, true));

$sums[0] = true;

for($i = 1; $i <= $N; ++$i) {
    for($j = 0; $j < count($factors); ++$j) {
        if($factors[$j] > $i) break;

        if($sums[$i - $factors[$j]]) {
            $sums[$i] = true;
            continue 2;
        }
    }
    $sums[$i] = false;
}

$solutions = 0;

for($i = 0; $i <= intdiv($N, 2); ++$i) {
    if($sums[$i] && $sums[$N - $i]) {
        //We can't put 0 tubes and if the opposite is the same we only count it once
        $solutions += ($i == 0 || ($i == ($N - $i))) ? 1 : 2;
    }  
} 

echo $solutions;
?>
