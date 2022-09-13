<?php
$start = microtime(1);

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $S);
$string = stream_get_line(STDIN, 100 + 1, "\n");

$sizeS = strlen($S);
$solutions = [];

function solve($string, $list, $index, $left, $sum) {
    global $solutions, $sizeS;

    //We are only missing one number, we have to use all the digits that are left
    if($left == 1) {
        //We have reached the sum
        if($sum == $string) {
            $list[] = $string;
            $solutions[] = $list;
        }
        return;
    }

    $size = strlen($string); //Number of digits left
    $maxSize = min($sizeS, $size - $left + 1); //The maximum number of digits we can use
    $left--; //Number of integers we still need to create after the current one

    for($i = 1; $i <= $maxSize; ++$i) {
        $number = substr($string, 0, $i);
        $updatedSum = $sum - $number;

        //We have already a sum that is too big
        if($updatedSum < 0) break;

        //If we are forced to use a number with more digits than the number of digits in sum left to find it can't be a solution
        if(strlen($updatedSum) < ceil(($size - $i) / $left)) continue;

        $list[$index] = $number;
        solve(substr($string, $i), $list, $index + 1, $left, $updatedSum);
    }
}

solve($string, [], 0, $N, $S);

if(count($solutions) == 0) echo "No solution\n";
else echo implode("\n", array_map(function($solution) use($S) {
    return implode("+", $solution) . "=" . $S;
}, $solutions)) . PHP_EOL;

error_log(var_export(microtime(1) - $start, true));
?>
