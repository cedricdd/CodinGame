<?php

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    [$cityA, $cityB] = explode(" ", trim(fgets(STDIN)));

    $paths[$cityA][] = $cityB;
    $paths[$cityB][] = $cityA;
}

function solve(int $city, array $visited): int {

    global $paths;

    if($city == 100) return 1; //Found a road to Rome
    if(isset($visited[$city])) return 0; //We can't visit a city more than once, dead end
    else $visited[$city] = 1;

    $result = 0;

    //Check all the destination from this city
    foreach($paths[$city] as $destinationCity) {
        $result += solve($destinationCity, $visited);
    }

    return $result;
}

echo solve(1, []) . PHP_EOL;
?>
