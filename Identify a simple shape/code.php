<?php

$totalPoints = 0;

for ($y = 0; $y < 20; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $c) {
        if($c == "#") {
            $pointsR[$x][] = [$x, $y];
            $pointsC[$y][] = [$x, $y];
            $rows[$x] = ($rows[$x] ?? 0) + 1;
            $cols[$y] = ($cols[$y] ?? 0) + 1;
            ++$totalPoints;
        }
    }
}

ksort($rows); //Cols is already in the right order

//Get all the borders of the shape
[$x, $y] = reset($pointsR[array_key_first($rows)]); //Lowest X => Lowest Y of the col
$borders[$x . "-" . $y] = [$x, $y];
[$x, $y] = end($pointsR[array_key_first($rows)]); //Lowest X => Highest Y of the col
$borders[$x . "-" . $y] = [$x, $y];
[$x, $y] = reset($pointsR[array_key_last($rows)]); //Highest X => Lowest Y of the col
$borders[$x . "-" . $y] = [$x, $y];
[$x, $y] = end($pointsR[array_key_last($rows)]); //Highest X => Highest Y of the col
$borders[$x . "-" . $y] = [$x, $y];
[$x, $y] = reset($pointsC[array_key_first($cols)]); //Lowest Y => Lowest X of the row
$borders[$x . "-" . $y] = [$x, $y];
[$x, $y] = end($pointsC[array_key_first($cols)]); //Lowest Y => Highest X of the row
$borders[$x . "-" . $y] = [$x, $y];
[$x, $y] = reset($pointsC[array_key_last($cols)]); //Highest Y => Lowest X of the row
$borders[$x . "-" . $y] = [$x, $y];
[$x, $y] = end($pointsC[array_key_last($cols)]); //Highest Y => Highest X of the row
$borders[$x . "-" . $y] = [$x, $y];

//Ordered in ascending order of x then y
usort($borders, function($a, $b) {
    if($a[0] == $b[0]) return $a[1] <=> $b[1];
    else return $a[0] <=> $b[0];
});

switch(count($borders)) {
    case 1: $type = "POINT"; break;
    case 2: $type = "LINE"; break;
    case 3: 
        $s1 = max(abs($borders[1][0] - $borders[0][0]), abs($borders[1][1] - $borders[0][1])) + 1;
        $s2 = max(abs($borders[2][0] - $borders[0][0]), abs($borders[2][1] - $borders[0][1])) + 1;
        $s3 = max(abs($borders[2][0] - $borders[1][0]), abs($borders[2][1] - $borders[1][1])) + 1;

        $type = (($s1 + $s2 + $s3 - 3 != $totalPoints) ? "FILLED" : "EMPTY") . " TRIANGLE";
        break;
    case 4: 
        $width = abs($borders[2][0] - $borders[0][0]) + 1;
        $height = abs($borders[1][1] - $borders[0][1]) + 1;

        $type = ((($width * 2 + $height * 2 - 4) != $totalPoints) ? "FILLED" : "EMPTY") . " " . (($width == $height) ? "SQUARE" : "RECTANGLE");
        break;
}

echo $type . " " . implode(" ", array_map(function($border) {
    return "(" . implode(",", $border) . ")";
}, $borders)) . PHP_EOL;
