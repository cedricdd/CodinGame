<?php

fscanf(STDIN, "%d %d", $numRecipe, $numIngredients);
for ($i = 0; $i < $numRecipe; $i++) {
    if(preg_match("/- ([0-9\.]+)([kgclL]+) (.*)/", trim(fgets(STDIN)), $matches)) {
        $matches[2] = strtolower($matches[2]); //L is the only one in uppercase

        if($matches[2] == "l") $matches[1] = intval($matches[1] * 100);
        if($matches[2] == "kg")  $matches[1] = intval($matches[1] * 1000);

        $recipe[$matches[3]] = $matches[1];
    }
}

for ($i = 0; $i < $numIngredients; $i++) {
    preg_match("/(.*) ([0-9\.]+)([kgclL]+)/", trim(fgets(STDIN)), $matches);

    $matches[3] = strtolower($matches[3]); //L is the only one in uppercase

    if($matches[3] == "l") $matches[2] = intval($matches[2] * 100);
    if($matches[3] == "kg") $matches[2] = intval($matches[2] * 1000);

    $ingredients[] = [$matches[1], $matches[3][-1], intval($matches[2])];
    $turns[] = round($matches[2] / $recipe[$matches[1]], 3);
}

$times = min($turns); //The number of times we can make the recipe
$minIndex = array_search($times, $turns);

echo $ingredients[$minIndex][0] . PHP_EOL . floor($times) . PHP_EOL;

unset($ingredients[$minIndex]); //Don't output the limiting_ingredient

//Update the quantities
foreach($ingredients as $index => [$name, , &$quantity]) {
    $quantity = $quantity - $recipe[$name] * floor($times);
}

//Sort for display
uasort($ingredients, function($a, $b) {
    if($a[1] != $b[1]) return $a[1] <=> $b[1]; //Solid first
    else return $a[2] <=> $b[2]; //Ordered by quantity, in ascending order
});

foreach($ingredients as $index => [$name, $unit, $quantityLeft]) {
    if($quantityLeft < 1000) echo $name . " " . $quantityLeft . ($unit == "g" ? "g" : "cl") . PHP_EOL;
    else {
        //Convert the value to new unit
        $quantityLeft /= ($unit == "g" ? 1000 : 100);

        //Output wants a float even for integers
        if($quantityLeft == intval($quantityLeft)) $quantityLeft .= ".0";

        echo $name . " " . $quantityLeft . ($unit == "g" ? "kg" : "L") . PHP_EOL;
    }
}
