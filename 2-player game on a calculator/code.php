<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/
fscanf(STDIN, "%d", $N);
error_log(var_export($N, true));

$p = [
    1 => [2, 4, 5],
    2 => [1, 3, 4, 5, 6],
    3 => [2, 5, 6],
    4 => [1, 2, 5, 7, 8],
    5 => [1, 2, 3, 4, 6, 7, 8, 9],
    6 => [2, 3, 5, 8, 9],
    7 => [4, 5, 8],
    8 => [4, 5, 6, 7, 9],
    9 => [5, 6, 8],
];

$memorization = [];

function solve($N, $last) {
    global $memorization, $p;

    if(isset($memorization[$N][$last])) return $memorization[$N][$last];

    if($N - $last < 0) return false;
    
    foreach($p[$last] as $number) {
        $status = solve($N - $last, $number);

        if($status) return $memorization[$N][$last] = false;
    }

    return $memorization[$N][$last] = true;
}

foreach(range(1, 9) as $number) {
    if(solve($N, $number)) $good[] = $number; 
}

echo implode(" ", $good);
?>
