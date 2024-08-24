<?php

$buy = [];
$sell = [];
$trades = [];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %s %d %f", $symbol, $action, $quantity, $price);

    //It's a buy order
    if($action == "BUY") {
        $infos = $sell[$symbol] ?? []; //Get all the sell order for this stock

        uasort($infos, function($a, $b) {
            if($a[1] == $b[1]) return $a[2] <=> $b[2]; //We need to buy from the first seller
            else return $a[1] <=> $b[1]; //We want to buy at the best price possible
        });

        foreach($infos as $id => [$quantitySell, $priceSell]) {
            //We can buy from this seller, the price is good
            if($priceSell <= $price) {
                $quantitySold = min($quantitySell, $quantity);
                $priceSold = min($priceSell, $price);

                $trades[] = "$symbol $quantitySold " . number_format($priceSold, 2);

                if(($sell[$symbol][$id][0] -= $quantitySold) == 0) unset($sell[$symbol][$id]); //The seller has nothing left to sell
                if(($quantity -= $quantitySold) == 0) break; //The buy order is completed
            }
        }

        if($quantity) $buy[$symbol][] = [$quantity, $price, $i];
    } else {
        $infos = $buy[$symbol] ?? []; //Get all the buy order for this stock

        uasort($infos, function($a, $b) {
            if($a[1] == $b[1]) return $a[2] <=> $b[2]; //We need to sell to the first buyer
            else return $b[1] <=> $a[1]; //We want to sell at the best price possible
        });

        foreach($infos as $id => [$quantityBuy, $priceBuy]) {
            //We can sell to this buyer, the price is good
            if($priceBuy >= $price) {
                $quantityBought = min($quantityBuy, $quantity);
                $priceBought = max($priceBuy, $price);

                $trades[] = "$symbol $quantityBought " . number_format($priceBought, 2);

                if(($buy[$symbol][$id][0] -= $quantityBought) == 0) unset($buy[$symbol][$id]); //The buyer has nothing left to buy
                if(($quantity -= $quantityBought) == 0) break; //The sell order is completed
            }
        }

        if($quantity) $sell[$symbol][] = [$quantity, $price, $i];
    }
}

if(count($trades) == 0) echo "NO TRADE" . PHP_EOL;
else echo implode("\n", $trades) . PHP_EOL;
