<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

 //https://en.wikipedia.org/wiki/Analysis_of_algorithms

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $num, $t);
    $coeff = ($i > 0) ? log($t / $info[$i-1][1])/log($num / $info[$i-1][0]) : 0;
    $info[] = [$num, $t, $coeff];
}

//Drop the first, no coeff
array_shift($info);

$average = (array_sum(array_column($info, 2)) / $N);
error_log(var_export($average, true));

if($average < 0.05) echo "O(1)";
elseif($average < 0.2) echo "O(log n)";
elseif($average < 1.05) echo "O(n)";
elseif($average < 1.2) echo "O(n log n)";
elseif($average < 2.1) echo "O(n^2)";
elseif($average < 2.4) echo "O(n^2 log n)";
elseif($average < 3.2) echo "O(n^3)";
else echo "O(2^n)";
?>
