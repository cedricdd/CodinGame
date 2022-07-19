<?php

function getRoad(array $map, int $n, int $x, int $y, string $player, int $size) {

    //End of this road
    if($x < 0 || $x >= $n || $y < 0 || $y >= $n || strtolower($map[$y][$x]) != $player) return $size;

    if($map[$y][$x] == $player) ++$size; //It's a road not a town
    $map[$y][$x] = "#"; //Don't go on the same spot multiple times

    //We test the 4 cardinal directions
    return max(
        getRoad($map, $n, $x, $y - 1, $player, $size),
        getRoad($map, $n, $x, $y + 1, $player, $size),
        getRoad($map, $n, $x - 1, $y, $player, $size),
        getRoad($map, $n, $x + 1, $y, $player, $size)
    );
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $map[] = stream_get_line(STDIN, $n + 1, "\n");
}

//We don't know where is the end/start of a road, we need to test all the locations
for($y = 0; $y < $n; ++$y) {
    for($x = 0; $x < $n; ++$x) {
        if($map[$y][$x] != "#") {
            $player = strtolower($map[$y][$x]);

            $length = getRoad($map, $n, $x, $y, $player, 0);

            if($length >= 5 && $length > ($winner[1] ?? 0)) $winner = [ucfirst($player), $length];
         }
    }
}

if(isset($winner)) echo implode(" ", $winner) . "\n";
else echo "0\n";
?>
