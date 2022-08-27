<?php

fscanf(STDIN, "%d %d %d %d", $w, $h, $countX, $countY);

$X = [0];
$Y = [0];
$sizes = [];
$countSquare = 0;

$inputs = explode(" ", fgets(STDIN));
$inputs[] = $w;

foreach($inputs as $input) {
    $position = intval($input);

    foreach($X as $previous) {
        //Save how many time we have this size on the X axis
        $sizes[$position - $previous] = ($sizes[$position - $previous] ?? 0) + 1;
    }

    $X[] = $position;
}

$inputs = explode(" ", fgets(STDIN));
$inputs[] = $h;

foreach($inputs as $input) {
    $position = intval($input);

    foreach($Y as $previous) {
        //Each time we have the same size on the X axis we have a square
        $countSquare += ($sizes[$position - $previous] ?? 0);
    }

    $Y[] = $position;
}

echo($countSquare . "\n");
?>
