<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d %d %d %d", $W, $H, $T1, $T2, $T3);

error_log(var_export($T1 . " " . $T2 . " " . $T3, true));

for ($y = 0; $y < $H; ++$y)
{
    fscanf(STDIN, "%s %s", $firstPicture[$y], $secondPicture[$y]);

    foreach (str_split($firstPicture[$y]) as $x => $character) {
        if($character != '.') $asteroids[$character][1] = [$x, $y];
    }

    foreach (str_split($secondPicture[$y]) as $x => $character) {
        if($character != '.') $asteroids[$character][2] = [$x, $y];
    }
}

error_log(var_export($firstPicture, true));
error_log(var_export($secondPicture, true));

$output = array_fill(0, $H, array_fill(0, $W, '.'));

krsort($asteroids);

foreach ($asteroids as $character => $info) {
    $x = $info[2][0] + floor(($info[2][0] - $info[1][0]) / ($T2 - $T1) * ($T3 - $T2));
    $y = $info[2][1] + floor(($info[2][1] - $info[1][1]) / ($T2 - $T1) * ($T3 - $T2));

    if($x >= $W || $x < 0 || $y >= $H || $y < 0) continue;
    $output[$y][$x] = $character;
}

foreach ($output as $line) {
    echo implode('', $line) . "\n";
}
?>
