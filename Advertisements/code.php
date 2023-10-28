<?php

$start = microtime(1);

//Generate all the order permutations to check the ads
function generateAdsPermutations(array $ads, array $permutation): array {

    if(count($ads) == 0) return [$permutation]; //We are using all the ads
   
    $results = [];

    foreach($ads as $name => $info) {
        
        unset($ads[$name]);
        $permutation[$name] = $info;

        $results = array_merge($results, generateAdsPermutations($ads, $permutation));

        $ads[$name] = $info;
        array_pop($permutation);
    }

    return $results;
}

//Generate all the permutations of $size items
function generateItemsPermutations(int $size, array $items, array $permutation): array {

    $countP = count($permutation);
    $countI = count($items);

    if($countP == $size) return [$permutation];
    if($countP + $countI < $size) return [];

    $results = [];

    //Get the last items in the array
    $itemID = array_key_last($items);
    $itemPrice = array_pop($items);

    //We don't use the item
    $results = array_merge($results, generateItemsPermutations($size, $items, $permutation));

    $permutation[$itemID] = $itemPrice;

    //We use the item
    $results = array_merge($results, generateItemsPermutations($size, $items, $permutation));

    return $results;
}

//Apply a group of advertisments
function applyAdvertisments(array $adsGroup, array $items, array &$itemsPerAds, float $discount): array {
    //If we have more than one ad to apply we need to test all the order permutations
    $adsPermutations = generateAdsPermutations($adsGroup, []);

    $bestDiscount = -INF;
    $bestItems = [];

    foreach($adsPermutations as $ads) {

        //Applying an ad might produce multiple results
        $possibilities = [[$discount, $items]];

        foreach($ads as $name => [$X, $Y]) {

            $newPossibilities = [];

            foreach($possibilities as [$discountPermutation, $itemsPermutation]) {
                //The list of items we haven't used yet that are related to the ad we are currently working on
                $itemsAd = array_intersect_key($itemsPermutation, $itemsPerAds[$name]);

                $turns = intdiv(count($itemsAd), $X); //Number of time the ad can be applied

                //Not enough items left for this ad, nothing changes
                if($turns == 0) {
                    $newPossibilities[] = [$discountPermutation, $itemsPermutation];
                    continue;
                }

                //Sort by ascending prices
                asort($itemsAd);

                if($X > $Y) {
                    //Remove the X - Y most expansive items $turns times
                    for($j = ($X - $Y) * $turns; $j > 0; --$j) {
                        $index = array_key_last($itemsAd);
                        $price = array_pop($itemsAd);
    
                        unset($itemsPermutation[$index]);
    
                        $discountPermutation += $price;
                    }

                    //All the items associated with this ad we have left need to be removed
                    if(($Y * $turns) == count($itemsAd)) $newPossibilities[] = [$discountPermutation, array_diff_key($itemsPermutation, $itemsAd)];
                    //We need to test all the possible way of removing ($Y * $turns) items
                    else {
                        $itemsRemoved = generateItemsPermutations($Y * $turns, $itemsAd, []);

                        foreach($itemsRemoved as $listItems) $newPossibilities[] = [$discountPermutation, array_diff_key($itemsPermutation, $listItems)];
                    }
                } else {
                    //Remove the cheapest items $turns times
                    for($j = $turns; $j > 0; --$j) {
                        $index = array_key_first($itemsAd);
                        $price = $itemsAd[$index];
                        unset($itemsAd[$index]); //array_shift would reset all the indexes

                        $discountPermutation -= $price * ($Y - $X);
        
                        unset($itemsPermutation[$index]);
                    }

                    //All the items associated with this ad we have left need to be removed
                    if(($X - 1) * $turns == count($itemsAd)) $newPossibilities[] = [$discountPermutation, array_diff_key($itemsPermutation, $itemsAd)];
                    //We need to test all the possible way of removing ($X - 1) * $turns items
                    else {
                        $itemsRemoved = generateItemsPermutations(($X - 1) * $turns, $itemsAd, []);

                        foreach($itemsRemoved as $listItems) $newPossibilities[] = [$discountPermutation, array_diff_key($itemsPermutation, $listItems)];
                    } 
                }
            }

            $possibilities = $newPossibilities;
        }

        //We have applied all the ads in the group, search for the best discount
        foreach($possibilities as [$discountPermutation, $itemsPermutation]) {
            if($discountPermutation > $bestDiscount) {
                $bestDiscount = $discountPermutation;
                $bestItems = $itemsPermutation;
            }
        }
    }

    return [$bestDiscount, $bestItems];
}

fscanf(STDIN, "%d", $na);
for ($i = 0; $i < $na; $i++) {
    preg_match("/All (.*): ([0-9]+) for the price of ([0-9]+)/", trim(fgets(STDIN)), $matches);

    $advertisements[$matches[1]] = [$matches[2], $matches[3]];
}

$discount = 0.0;
$total = 0.0;
$itemID = 0;
$adsGroups = [];
$conflictAds = [];

fscanf(STDIN, "%d", $ni);
for ($i = 0; $i < $ni; $i++) {
    fscanf(STDIN, "%s %s %s %s", $product, $group, $brand, $price);

    $potentialAds = [];

    //Check if this item could be associated with an ad
    foreach([$product, $group, $brand] as $name) {
        if(isset($advertisements[$name])) {
            $itemsPerAds[$name][$itemID] = 1;
            $potentialAds[$name] = 1;
        }
    }

    //If this items could be associated with multiple ads these ads are "conflicting"
    if(count($potentialAds) > 1) {

        foreach($potentialAds as $name => $filler) {
            foreach($conflictAds as $conflictID => $listAds) {
                //We already have a conflict group with at least on the ads related to the items, update the group
                if(isset($listAds[$name])) {
                    $conflictAds[$conflictID] += $potentialAds;
                    $potentialAds = null;

                    break 2;
                }
            }
        }

        //Create a new conflict group
        if($potentialAds !== null) $conflictAds[] = $potentialAds;
    }

    $items[$itemID++] = floatval($price);
    $total += $price;
}

foreach($conflictAds as $listAds) {
    $adsGroup = [];

    //All the ads in a conflict group need to be checked together, checking all the order permutations 
    foreach($listAds as $name => $filler) {
        $adsGroup[$name] = $advertisements[$name];
        
        unset($advertisements[$name]);
    }

    $adsGroups[] = $adsGroup;
}

//The ads that are left can be check independently 
foreach($advertisements as $name => [$X, $Y]) {
    if(count($itemsPerAds[$name] ?? []) < $X) continue;

    $adsGroups[] = [$name => [$X, $Y]];
}

foreach($adsGroups as $adsGroup) {
    [$discount, $items] = applyAdvertisments($adsGroup, $items, $itemsPerAds, $discount);
}

echo number_format($total - $discount, 2) . PHP_EOL . number_format($discount, 2) . PHP_EOL;

error_log(microtime(1) - $start);
