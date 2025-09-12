<?php

function getScore(string $character): int {
    switch($character) {
        case '.': return 1; break;
        case ')': return 3; break;
        case '*': return 5; break;
        default: return 0;
    }
}

function solve(int $index, int $energy, string $hash): int {
    global $fruits, $moves, $w;
    static $history = [];

    if($energy < 0) return 0; //We can't move anymore

    //We have previously reached this position after eating the same fruit and we don't have more energy left than previously
    if(isset($history[$hash][$index]) && $history[$hash][$index] >= $energy) return 0; 
    else $history[$hash][$index] = $energy;

    //We are eating a fruit
    if(isset($fruits[$index]) && $hash[$fruits[$index][0]] == '1') {
        $score = $fruits[$index][1];
        $hash[$fruits[$index][0]] = '0';
    } else $score = 0;

    $max = 0;

    //Test each moves possible at this position
    foreach($moves[$index] as [$neighbor, $cost]) {
        $result = solve($neighbor, $energy - $cost, $hash);

        if($result > $max) $max = $result;
    }

    return $score + $max;
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $w, $h);
fscanf(STDIN, "%d", $energy);

for ($i = 0; $i < $h; $i++) {
    $map[] = stream_get_line(STDIN, $w + 1, "\n");
}

error_log(var_export($map, 1));

//Mark all the position next to a ghost as a wall
for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if($map[$y][$x] == 'G') {
            $y2 = ($y - 1 + $h) % $h;
            if($map[$y2][$x] != 'G') $map[$y2][$x] = '#';

            $y2 = ($y + 1) % $h;
            if($map[$y2][$x] != 'G') $map[$y2][$x] = '#';

            $x2 = ($x - 1 + $w) % $w;
            if($map[$y][$x2] != 'G') $map[$y][$x2] = '#';

            $x2 = ($x + 1) % $w;
            if($map[$y][$x2] != 'G') $map[$y][$x2] = '#';
        } elseif($map[$y][$x] == 'P') {
            [$xs, $ys] = [$x, $y];
            $map[$y][$x] = ' ';
        } 
    }
}

$toCheck[] = [$xs, $ys, $energy];
$moves = [];
$visited = [];
$fruits = [];
$fruitIndex = 0;

//Find all the fruits we can reach
while($toCheck) {
    [$x, $y, $e] = array_pop($toCheck);

    if($e < 0) continue; //Out of energy

    $index = $y * $w + $x;
    $moves[$index] = [];

    //We only continue if we reach a position we have previously reached if we have more energy left
    if(isset($visited[$index]) && $visited[$index] >= $e) continue; 
    else $visited[$index] = $e;

    //There's a fruit in this position
    if($map[$y][$x] != ' ') {
        $fruits[$index] = [$fruitIndex++, getScore($map[$y][$x])];
        $map[$y][$x] = ' ';
    }

    //Left
    $cost = ($x == 0 ? 3 : 1);
    $x2 = ($x - 1 + $w) % $w;

    if($map[$y][$x2] != '#') {
        $toCheck[] = [$x2, $y, $e - $cost];
        $moves[$index]['L'] = [$y * $w + $x2, $cost];
    }

    //Right
    $cost = ($x == $w - 1 ? 3 : 1);
    $x2 = ($x + 1) % $w;

    if($map[$y][$x2] != '#') {
        $toCheck[] = [$x2, $y, $e - $cost];
        $moves[$index]['R'] = [$y * $w + $x2, $cost];
    }

    //Up
    $cost = ($y == 0 ? 3 : 1);
    $y2 = ($y - 1 + $h) % $h;

    if($map[$y2][$x] != '#') {
        $toCheck[] = [$x, $y2, $e - $cost];
        $moves[$index]['U'] = [$y2 * $w + $x, $cost];
    }

    //Down
    $cost = ($y == $h - 1 ? 3 : 1);
    $y2 = ($y + 1) % $h;

    if($map[$y2][$x] != '#') {
        $toCheck[] = [$x, $y2, $e - $cost];
        $moves[$index]['D'] = [$y2 * $w + $x, $cost];
    }
}


$hash = str_repeat('1', $fruitIndex); //Representation of the fruits we can pick

echo solve($ys * $w + $xs, $energy, $hash) . PHP_EOL;

error_log(microtime(1) - $start);
