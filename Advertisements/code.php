<?php

fscanf(STDIN, "%d", $na);
for ($i = 0; $i < $na; $i++) {
    preg_match("/All (.*): ([0-9]+) for the price of ([0-9]+)/", trim(fgets(STDIN)), $matches);

    $advertisements[$matches[1]][] = [$matches[2], $matches[3]];
}

error_log(var_export($advertisements, true));

$total = 0.0;
$discount = 0.0;

fscanf(STDIN, "%d", $ni);
for ($i = 0; $i < $ni; $i++) {
    fscanf(STDIN, "%s %s %s %s", $product, $group, $brand, $price);

    if(isset($advertisements[$product]) || isset($advertisements[$group]) || isset($advertisements[$brand])) {
        $items[] = [$product, $group, $brand, $price];
    }

    $total += $price;
}

error_log(var_export($items, true));

while(true) {
    $discounts = [];

    foreach($advertisements as $name => $list) {
        $itemsFiltered = [];

        foreach($list as [$X, $Y]) {
            foreach($items as $i => [$product, $group, $brand, $price]) {
                if($product == $name || $group == $name || $brand == $name) {
                    $itemsFiltered[$i] = $price;
                }
            }
    
            asort($itemsFiltered);
            $count = count($itemsFiltered);

            //error_log(var_export("filtered for $name", true));
            error_log(var_export($itemsFiltered, true));

            if($X > $count) continue;

            $keys = array_keys($itemsFiltered);
    
            if($X > $Y) {
                $discounts[$name] = [array_sum(array_slice($itemsFiltered, -($X - $Y))), array_merge(array_slice($keys, 0, $Y), array_slice($keys, -($X - $Y)))];
            } else {
                $discounts[$name] = [reset($itemsFiltered) * -($Y - $X), array_merge(array_slice($keys, 0, 1), array_slice($keys, -($X - 1)))];
            }
        }
    }

    error_log(var_export($discounts, true));

    //error_log("count is " . count($discounts)) . PHP_EOL;

    if(count($discounts) == 0) break;

    usort($discounts, function($a, $b) {
        return $b[0] <=> $a[0];
    });

    //error_log(var_export($discounts, true));

    $discount += $discounts[0][0];
    foreach($discounts[0][1] as $index) unset($items[$index]);
}

echo number_format($total - $discount, 2) . PHP_EOL . number_format($discount, 2) . PHP_EOL;
