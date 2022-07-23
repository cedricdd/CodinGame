<?php

$people = 1;
$total = 0;
$friends = [];
$unliked = [];

fscanf(STDIN, "%d %d %d", $n, $baseCost, $additionalCost);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d", $budget, $joy);

    //That friend won't be able to join no matter what
    if($budget < $additionalCost) continue;
    if($budget == $additionalCost && $baseCost > 0) continue;

    else $inputs[] = [$budget, $joy];
}

$max = count($inputs) + 1;

foreach($inputs as $key => $info) {
    list($budget, $joy) = $info;

    if($budget == $additionalCost) $min = 0;
    else $min = ceil($baseCost / ($budget - $additionalCost));

    //Eliminate friends (bad & good) that wouldn't be able to come even if all friends would be joining
    if($min <= $max) {
        if($joy >= 0) $friends[$min][] = $joy;
        else $unliked[$min][] = abs($joy);
    }
}

ksort($friends);
ksort($unliked);

$checkCount = $people;
$best = 0;

//Find the max numbers of good friends that can join whitout adding any unliked
foreach($friends as $needed => $list) {
    $checkCount += count($list);
    if($checkCount >= $needed) $best = $needed;
}

foreach($friends  as $needed => $list) {
    if($needed > $best) break;

    foreach($list as $joy) {
        $total += $joy;
        ++$people; 
    }

    unset($friends[$needed]);
}

//No more good friends or no bad friends, we are done
if(count($friends) == 0 || count($unliked) == 0) exit("$total");

$tempTotal = $total;
//Foreach group of good friends that are left find best combinaison of bad friends needed
foreach($friends as $needed => $list) {

    $tempTotal += array_sum($list);
    $people += count($list);
    $missing = $needed - $people;

    if($missing > count($unliked)) continue; //Not enough bad friends to add them

    //Get all the bad friends that can join with the current number of people
    $additionalUnliked = [];
    foreach($unliked as $neededU => $listU) {
        if($neededU > $needed) break;

        foreach($listU as $value) $additionalUnliked[] = $value;
    }

    //We use the $missing bad friends with the lowest penalty 
    sort($additionalUnliked);
    $check = $tempTotal - array_sum(array_slice($additionalUnliked, 0, $missing));
    if($check > $total) $total = $check;
}

echo $total;
?>
