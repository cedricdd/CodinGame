<?php

fscanf(STDIN, "%d %d %d %d", $M, $A, $S, $N);

//Generate the numbers in the array
for($i = 0; $i < $N; ++$i) {
    $list[$i] = $A * ($list[$i - 1] ?? $S) % $M;
}

//Passing the array instead of the start/end IDs takes more memory but is faster
function mergeSort(array &$list): int {

    $length = count($list);

    if($length == 1) return 0;

    $middle = intdiv($length, 2);

    $left = array_slice($list, 0, $middle);
    $right = array_slice($list, $middle);

    $count = mergeSort($left); //Sort the left array
    $count += mergeSort($right); //Sort the right array

    $indexL = 0;
    $indexR = 0;

    //Merge left & right arrays
    for($i = 0; $i < $length; ++$i) {
        if(($left[$indexL] ?? INF) > ($right[$indexR] ?? INF)) {
            $list[$i] = $right[$indexR++];
            //The smallest value is in the right, we increase the inversion by the # of numbers still waiting to be added in the left array
            $count += $middle - $indexL;
        } else {
            $list[$i] = $left[$indexL++];
        }
    }
    return $count;
}

echo mergeSort($list);
?>
