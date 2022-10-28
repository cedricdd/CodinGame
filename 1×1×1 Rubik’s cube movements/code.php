<?php

$positions = [0 => "F", 1 => "U", 2 => "B", 3 => "D", 4 => "L", 5 => "R"];
$cube = $positions;

function rotate(string $direction, array $cube): array {
    $rotated = $cube;

    switch($direction) {
        case "x":  $rotated[1] = $cube[0]; $rotated[2] = $cube[1]; $rotated[3] = $cube[2]; $rotated[0] = $cube[3]; break;
        case "x'": $rotated[0] = $cube[1]; $rotated[3] = $cube[0]; $rotated[2] = $cube[3]; $rotated[1] = $cube[2]; break;
        case "y":  $rotated[4] = $cube[0]; $rotated[2] = $cube[4]; $rotated[5] = $cube[2]; $rotated[0] = $cube[5]; break;
        case "y'": $rotated[5] = $cube[0]; $rotated[2] = $cube[5]; $rotated[4] = $cube[2]; $rotated[0] = $cube[4]; break;
        case "z":  $rotated[1] = $cube[4]; $rotated[5] = $cube[1]; $rotated[3] = $cube[5]; $rotated[4] = $cube[3]; break;
        case "z'": $rotated[1] = $cube[5]; $rotated[4] = $cube[1]; $rotated[3] = $cube[4]; $rotated[5] = $cube[3]; break;
    }

    return $rotated;
}

foreach(explode(" ", trim(fgets(STDIN))) as $rotation) {
    $cube = rotate($rotation, $cube);
}

echo $positions[array_search(trim(fgets(STDIN)), $cube)] . PHP_EOL;
echo $positions[array_search(trim(fgets(STDIN)), $cube)] . PHP_EOL;
