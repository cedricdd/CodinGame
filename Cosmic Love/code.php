<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %s %s %s", $name, $radius, $mass, $distance);

    $density = $mass / (4/3 * pi() * pow($radius, 3));

    //PHP is dynamically typed we don't need to worry about scientific notation
    $planets[$name] = ["radius" => $radius, "mass" => $mass, "distance" => $distance, "density" => $density];
}

$closest = "";

foreach($planets as $name => $info) {
    if($name == "Alice") continue;

    //Calculate the roche limit
    $rocheLimit = $planets["Alice"]["radius"] * ((2 * ($planets["Alice"]["density"] / $info["density"])) ** (1/3));

    //If planet won't get destroyed and it's closest to the current closest safe planet
    if($info["distance"] > $rocheLimit && (empty($closest) || $planets[$closest]["distance"] > $info["distance"])) $closest = $name;
}

echo $closest . PHP_EOL;
