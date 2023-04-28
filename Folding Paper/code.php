<?php

$layers = ["R" => 1, "L" => 1, "U" => 1, "D" => 1];

foreach(str_split(trim(fgets(STDIN))) as $fold) {
    switch($fold) {
        case "R":
            $layers["U"] *= 2;
            $layers["D"] *= 2;
            $layers["L"] += $layers["R"];
            break;
        case "L":
            $layers["U"] *= 2;
            $layers["D"] *= 2;
            $layers["R"] += $layers["L"];
            break;
        case "U":
            $layers["L"] *= 2;
            $layers["R"] *= 2;
            $layers["D"] += $layers["U"];
            break;
        case "D":
            $layers["L"] *= 2;
            $layers["R"] *= 2;
            $layers["U"] += $layers["D"];
            break;
    }

    $layers[$fold] = 1;
}

echo $layers[trim(fgets(STDIN))] . PHP_EOL;
