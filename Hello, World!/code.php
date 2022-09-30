<?php

//Get the rounded distance between 2 points
function getDistance(float $latitude, float $longitude, array $capital): int {
    return round(acos(sin($latitude) * sin($capital[1]) + cos($latitude) * cos($capital[1]) * cos(abs($longitude - $capital[2]))) * 6371);
}

//Get the latitude in radian
function getRadLatitude(string $latitude): float {
    return deg2rad((substr($latitude, 1, 2) + (substr($latitude, 3, 2) / 60) + (substr($latitude, 5) / 3600)) * ($latitude[0] == "N" ? 1 : -1));
}

//Get the longitude in radian
function getRadLongitude(string $longitude): float {
    return deg2rad((substr($longitude, 1, 3) + (substr($longitude, 4, 2) / 60) + (substr($longitude, 6) / 3600)) * ($longitude[0] == "E" ? 1 : -1));
}

// $n: number of capitals
fscanf(STDIN, "%d", $n);
// $m: number of geolocations for which to find the closest capital
fscanf(STDIN, "%d", $m);

for ($i = 0; $i < $n; $i++) {
    preg_match("/(.*) ([NS0-9]+) ([EW0-9]+)/", trim(fgets(STDIN)), $matches);

    $capitals[$i] = [$matches[1], getRadLatitude($matches[2]), getRadLongitude($matches[3])];
}
for ($i = 0; $i < $n; $i++) {
    $capitals[$i][3] = trim(fgets(STDIN));
}

for ($i = 0; $i < $m; $i++) {
    preg_match("/([NS0-9]+) ([EW0-9]+)/", trim(fgets(STDIN)), $matches);

    $latitude = getRadLatitude($matches[1]);
    $longitude = getRadLongitude($matches[2]);

    $closest = INF;
    $output = [];

    foreach($capitals as $capital) {
        $distance = getDistance($latitude, $longitude, $capital);

        //This POI is closer
        if($distance < $closest) {
            $closest = $distance;
            $output = [$capital[3]];
        } //This POI is at the same distance as the current closest
        elseif($distance == $closest) {
            $output[] = $capital[3];
        }
    }

    echo implode(" ", $output) . PHP_EOL;
}
?>
