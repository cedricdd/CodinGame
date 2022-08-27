<?php

$inputs = explode(" ", fgets(STDIN));
for ($i = 0; $i < 10; $i++) {
    $weight[] = intval($inputs[$i]);
}

$sum = array_sum($weight) / 4; //The sum of the weight of the 5 persons, each person goes on the scale 4 times

//#0 is the 2 persons with the less weight
//#1 is the person with the less weight and person with the middle weight
//#8 is the person with the most weight and person with the middle weight
//#9 is the 2 persons with the most weight

$middle = $sum - $weight[0] - $weight[9]; 

echo ($weight[1] - $middle) . " " . ($weight[0] - $weight[1] + $middle) . " " . $middle . " " . ($weight[9] - $weight[8] + $middle) . " " . ($weight[8] - $middle) . PHP_EOL;
?>
