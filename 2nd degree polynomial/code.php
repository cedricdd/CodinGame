<?php

fscanf(STDIN, "%f %f %f", $a, $b, $c);

$points[] = [0, $c]; //Intersection with y axis

if($a == 0) {
    if($b != 0) $points[] = [-1 * $c / $b, 0];
} else {
    $delta = $b * $b - 4 * $a * $c;

    if($delta == 0) {
        $points[] = [(-1 * $b / 2 * $a), 0];
    } elseif($delta > 0) {
        $points[] = [(-1 * $b + sqrt($delta)) / (2 * $a), 0];
        $points[] = [(-1 * $b - sqrt($delta)) / (2 * $a), 0];
    }
}

//Order from left to right
usort($points, function($a, $b) {
    if($a[0] === $b[0]) return $a[1] <=> $b[1];
    else return $a[0] <=> $b[0];
});
//Output format
$output = array_map(function($arr) {
    return "(" . round($arr[0], 2) . "," . round($arr[1], 2) . ")";
}, $points);

echo implode(",", $output);
?>
