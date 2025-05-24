<?php

$start = microtime(1);

fscanf(STDIN, "%d", $energy);
fscanf(STDIN, "%f", $move);
fscanf(STDIN, "%f", $jump);
fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $h);

$IDs = 0;

for ($y = 0; $y < $h; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if($c == 'G') [$xg, $yg] = [$x, $y];
        if($c == 'M') $mens[$y * $w + $x] = $IDs++;

        $map[$y][$x] = $c;
    }
}

$toCheck = [[$xg, $yg, $energy, str_repeat('0', $IDs)]];
$answer = 0;
$history = [];

while($toCheck) {
    [$x, $y, $energy, $hash] = array_pop($toCheck);

    $index = $y * $w + $x;

    if(isset($mens[$index])) {
        //We have already swatted this man
        if($hash[$mens[$index]] == '1') continue;

        $hash[$mens[$index]] = '1';

        if(($count = substr_count($hash, '1')) > $answer) $answer = $count;
    }

    if(isset($history[$index][$hash]) && $history[$index][$hash] >= $energy) continue;

    $history[$index][$hash] = $energy;

    //Cardinal move
    if($energy >= $move) {
        if($x > 0 && $map[$y][$x - 1] != '#') $toCheck[] = [$x - 1, $y, $energy - $move, $hash];
        if($x < $w - 1 && $map[$y][$x + 1] != '#') $toCheck[] = [$x + 1, $y, $energy - $move, $hash];
        if($y > 0 && $map[$y - 1][$x] != '#') $toCheck[] = [$x, $y - 1, $energy - $move, $hash];
        if($y < $h - 1 && $map[$y + 1][$x] != '#') $toCheck[] = [$x, $y + 1, $energy - $move, $hash];
    } //Jumping
    if($energy >= $jump) {
        if($x > 1 && $map[$y][$x - 2] != '#') $toCheck[] = [$x - 2, $y, $energy - $jump, $hash];
        if($x < $w - 2 && $map[$y][$x + 2] != '#') $toCheck[] = [$x + 2, $y, $energy - $jump, $hash];
        if($y > 1 && $map[$y - 2][$x] != '#') $toCheck[] = [$x, $y - 2, $energy - $jump, $hash];
        if($y < $h - 2 && $map[$y + 2][$x] != '#') $toCheck[] = [$x, $y + 2, $energy - $jump, $hash];
    }

}

echo $answer . PHP_EOL;

error_log(var_export(microtime(1) - $start, 1));
