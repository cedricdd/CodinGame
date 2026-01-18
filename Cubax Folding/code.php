<?php

gc_disable();

fscanf(STDIN, "%d", $N);

$start = microtime(1);
$layerSize = $N * $N;
$lastIndex = $layerSize * $N - 1;
$moves = [];
//Directly sort in alphabetical order to produce solution already sorted
$dirs = [
    'B' => -$layerSize,
    'D' => -$N,
    'F' =>  $layerSize,
    'L' => -1,
    'R' =>  1,
    'U' =>  $N,
];
$masks = [];
$distances = [];

for($i = 0; $i < $layerSize * $N; ++$i) $masks[$i] = 1 << $i;

for($z = 0; $z < $N; ++$z) {
    for($y = 0; $y < $N; ++$y) {
        for($x = 0; $x < $N; ++$x) {
            $index = $z * $layerSize + $y * $N + $x;

            $distances[$index] = abs($x - ($N - 1)) + abs($y - ($N - 1)) + abs($z - ($N - 1));

            for ($i = 1; $i < 4; $i++) {
                foreach ($dirs as $dir => $step) {
                    // Boundary checks
                    if (($dir === 'L' && $x < $i) ||
                        ($dir === 'R' && $x + $i >= $N) ||
                        ($dir === 'D' && $y < $i) ||
                        ($dir === 'U' && $y + $i >= $N) ||
                        ($dir === 'B' && $z < $i) ||
                        ($dir === 'F' && $z + $i >= $N)) {
                        continue;
                    }

                    $hash = 0;
                    for ($j = 1; $j <= $i; $j++) {
                        $index2 = $index + $j * $step;
                        $hash |= $masks[$index2];
                    }

                    $moves[$index][$i + 1][$dir] = [$index2, $hash];
                }
            }
        }
    }
}

function solve(int $index, int $p, int $hashCube, string $solution) {
    global $solutions, $blocks, $moves, $masks, $nbrBlocks, $lastIndex, $distances, $left;

    if($index == $lastIndex) {
        if($p == $nbrBlocks) $solutions[] = $solution;
        return;
    }

    if($distances[$index] >= $left[$p]) return;

    $size = $blocks[$p];
    $hashCube |= $masks[$index];
    $last = $solution[-1] ?? "";

    foreach($moves[$index][$size] ?? [] as $dir => [$index2, $hash]) {
        if($last == $dir) continue; //We need a 90°

        /**
         * On first turn we can only move U, R or F and on second turn we will always have two possibilities:
         * - After U we can move R or F
         * - After R we can move U or F
         * - After F we can move U or R
         * This gives us 6 possibilities, if we find a solution with one of the possibility we can "generate" 5 more solutions by using symmetry.
         * So we only focus on 1 of the possibility to prune a lot of branches.
         */
        if($p == 0 && $dir != 'U') continue;
        if($p == 1 && $dir != 'F') continue;

        if(($hashCube & $hash) == 0) {
            solve($index2, $p + 1, $hashCube | $hash, $solution . $dir);
        }
    }
}

$blocks = array_map('intval', str_split(stream_get_line(STDIN, 256 + 1, "\n")));
$nbrBlocks = count($blocks);
$solutions = [];
$left = [0 => $lastIndex + 1];

foreach($blocks as $i => $v) {
    $left[$i + 1] = $left[$i] - $v + 1;
}

solve(0, 0, 0, "");

//Base solution (first U then F) we group moves with their inverse
$base = "UDFBRL";
$symmetries = [
    "UDRLFB", //First U then R
    "FBRLUD", //First F then R
    "FBUDRL", //First F then U
    "RLUDFB", //First R then U
    "RLFBUD", //First R then F
];

//Generate the symmetry solution
foreach($solutions as $solution) {
    foreach($symmetries as $symmetry) 
        $solutions[] = strtr($solution, $base, $symmetry);
}

sort($solutions);

echo implode(PHP_EOL, $solutions) . PHP_EOL;

error_log(microtime(1) - $start);
