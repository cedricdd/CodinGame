<?php

$start = microtime(1);

function generateSubGroups(int $size, array $items, array $group, array &$results) {

    if(count($group) == $size) {
        $results[] = $group;
        return;
    }

    $productID = array_key_last($items);
    $product = array_pop($items);

    if($product === null) return;

    generateSubGroups($size, $items, $group, $results); //We don't use that product
    generateSubGroups($size, $items, $group + [$productID => $product], $results); //We use that product
}

fscanf(STDIN, "%d", $na);
for ($i = 0; $i < $na; $i++) {
    preg_match("/All (.*): ([0-9]+) for the price of ([0-9]+)/", trim(fgets(STDIN)), $matches);

    $advertisements[] = [$matches[1], $matches[2], $matches[3]];
}

$total = 0.0;

fscanf(STDIN, "%d", $ni);
for ($i = 0; $i < $ni; $i++) {
    fscanf(STDIN, "%s %s %s %s", $product, $group, $brand, $price);

    $items[] = [$product, $group, $brand, floatval($price)];
    $total += $price;
}

function solve(array $items, array $advertisements): float {
    static $history;

    //We can't apply any more ads
    if(count($items) == 0 || count($advertisements) == 0) return 0.0;

    $hash = implode("-", array_keys($advertisements)) . "|" . implode("-", array_keys($items)); 

    //if(isset($history[$hash])) return $history[$hash];

    $result = -INF;

    //error_log(var_export("calling solve", true));

    //Check all the advertisement left on the items left
    foreach($advertisements as $indexAd => [$name, $X, $Y]) {

        error_log("Working on $name $X $Y");

        $itemsAffected = [];

        //Find the items affected by the current advertisement
        foreach($items as $indexItem => [$product, $group, $brand, $price]) {
            if($product == $name || $group == $name || $brand == $name) {
                $itemsAffected[$indexItem] = $price;
            }
        }

        $turns = intdiv(count($itemsAffected), $X);

        //error_log(var_export($turns . " " . count($itemsAffected), true));

        if($turns == 0) {
            unset($advertisements[$indexAd]);

            continue;
        }

        //Sort by ascending prices
        asort($itemsAffected);

        $checks = [[0.0, $items, $itemsAffected]];

        //error_log(var_export($turns, true));

        for($i = 0; $i < $turns; ++$i) {
            $newChecks = [];

            foreach($checks as [$discount, $itemsFiltered, $itemsAffected]) {

                $count = count($itemsAffected);

                if($X > $Y) {
                    //Remove the X - Y most expansive items
                    for($j = $X - $Y; $j > 0; --$j) {
                        $index = array_key_last($itemsAffected);
                        $price = array_pop($itemsAffected);

                        //error_log("removing $index with $price");

                        unset($itemsFiltered[$index]);
    
                        $discount += $price;
                    }
    
                    error_log(var_export($itemsAffected, true));
    
                    $results = [];
    
                    generateSubGroups($Y, $itemsAffected, [], $results);
    
                    //error_log(var_export("we have " . count($results) . " possible results -- $discount", true));
                    
                    foreach($results as $removedItems) {
                        $newChecks[] = [$discount, array_diff_key($itemsFiltered, $removedItems), array_diff_key($itemsAffected, $removedItems)];
                    } 
    
                } else {
                    exit("!!!!!!!");

                    $index = array_key_first($itemsAffected);
                    $price = array_shift($itemsAffected);

                    $discount += $price * -($Y - $X);
    
                    //Remove the cheapest items
                    unset($itemsFiltered[$index]);
    
                    if($X > 1) {
                        //Remove the X - 1 most expansive items
                        $results = [];

                        generateSubGroups($X - 1, $itemsAffected, [], $results);

                        //error_log(var_export("we have " . count($results) . " possible results -- $discount", true));

                        //foreach(array_splice($itemsAffected, -($X - 1), $count, []) as [$index, ]) unset($itemsFiltered[$index]);

                        foreach($results as $removedItems) {
                            $newChecks[] = [$discount, array_diff_key($itemsFiltered, $removedItems), array_diff_key($itemsAffected, $removedItems)];
                        }
                    }
                }
            }

            //error_log(var_export($newChecks, true));

            $checks = $newChecks;
        }

        $updatedAdvertisements = $advertisements;
        unset($updatedAdvertisements[$indexAd]); //We can only apply the advertisement once

        error_log(var_export($checks, true));

        //error_log(var_export("we have " . count($checks) . " possible checks", true));

        foreach($checks as [$discount, $itemsFiltered, ]) {
            $discount += solve($itemsFiltered, $updatedAdvertisements); //Try to apply more advertisements

            error_log(var_export("having result $discount for $name", true));

            if($discount > $result) $result = $discount;
        }
    }

    return $history[$hash] = $result;
}

$discount = solve($items, $advertisements);

error_log(var_export("best is $discount", true));

if($discount === -INF) $discount = 0;

echo number_format($total - $discount, 2) . PHP_EOL . number_format($discount, 2) . PHP_EOL;

error_log(microtime(1) - $start);
