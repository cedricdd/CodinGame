<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
$inputs = array_map('intval', explode(" ", fgets(STDIN)));

$memorization = [];

function solve(int $i, array $limits): int {
    global $inputs, $N, $memorization ;

    //Using saved info
    if(isset($memorization[$i][$limits[0]][$limits[1]])) return $memorization[$i][$limits[0]][$limits[1]];

    //Nothing left to add
    if($i == $N) return 0;

    //Case where we skip current value
    $result = solve($i + 1, $limits);

    //We can add the car at the start
    if($inputs[$i] > $limits[0]) {
        //It's the first car we add, it becomes the highest & lowest
        if($limits[1] == 0) {
            $result = max($result, solve($i + 1, [$inputs[$i], $inputs[$i]]) + 1);
        } else {
            $result = max($result, solve($i + 1, [$inputs[$i], $limits[1]]) + 1);
        }
    } //We can add the car at the end
    elseif($inputs[$i] < $limits[1]) {
        $result = max($result, solve($i + 1, [$limits[0], $inputs[$i]]) + 1);
    } 

    return $memorization[$i][$limits[0]][$limits[1]] = $result;
}

echo solve(0, [0, 0]);
?>
