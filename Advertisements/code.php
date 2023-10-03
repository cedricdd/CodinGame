<?php

$start = microtime(1);

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
    static $history, $test = 0;

    //We can't apply any more ads
    if(count($items) == 0 || count($advertisements) == 0) return 0.0;

    //Check if we already know the result
    asort($advertisements);

    $hash = implode("-", array_column($advertisements, 0));
    
    if(isset($history[$hash])) return $history[$hash];

    $result =-INF;

    //Check all the advertisement left on the items left
    foreach($advertisements as $indexA => [$name, $X, $Y]) {

        $discount = 0.0;
        $itemsFiltered = $items;
        $itemsAffected = [];

        //Find the items affected by the current advertisement
        foreach($itemsFiltered as $indexI => [$product, $group, $brand, $price]) {
            if($product == $name || $group == $name || $brand == $name) {
                $itemsAffected[] = [$indexI, $price];
            }
        }

        //Sort by ascending prices
        usort($itemsAffected, function($a, $b) {
            return $a[1] <=> $b[1];
        });

        //Aplly the advertisement as many time as possible
        while($X <= ($count = count($itemsAffected))) {

            if($X > $Y) {
                $discount += array_sum(array_column(array_slice($itemsAffected, -($X - $Y)), 1));
                //Remove the Y cheapest items
                foreach(array_splice($itemsAffected, 0, $Y, []) as [$index, ]) {
                    //error_log("unset $index");
                    unset($itemsFiltered[$index]);
                }
                //Remove the X - Y most expansive items
                foreach(array_splice($itemsAffected, -($X - $Y), $count, []) as [$index, ]) unset($itemsFiltered[$index]);
            } else {
                $discount += $itemsAffected[0][1] * -($Y - $X);

                //Remove the cheapest items
                foreach(array_splice($itemsAffected, 0, 1, []) as [$index, ]) unset($itemsFiltered[$index]);

                if($X > 1) {
                    //Remove the X - 1 most expansive items
                    foreach(array_splice($itemsAffected, -($X - 1), $count, []) as [$index, ]) unset($itemsFiltered[$index]);
                }
            }
        }

        unset($advertisements[$indexA]); //We can only apply the advertisement once

        $discount += solve($itemsFiltered, $advertisements); //Try to apply more advertisements

        $advertisements[$indexA] = [$name, $X, $Y]; //Re-add the advertisement for the next recursives

        if($discount > $result) $result = $discount;
    }

    return $history[$hash] = $result;
}

$discount = solve($items, $advertisements);

echo number_format($total - $discount, 2) . PHP_EOL . number_format($discount, 2) . PHP_EOL;

error_log(microtime(1) - $start);
