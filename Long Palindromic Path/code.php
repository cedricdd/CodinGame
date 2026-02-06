<?php

function setLetters(array $path, int $N): array {
    $line = str_repeat("*", $N);
    $grid = array_fill(0, $N, $line);
    $letters = array_flip(range('a', 'z'));

    $end = $N * $N - 1;
    $max = ceil($N * $N / 2);

    for($i = 0; $i <= $max; ++$i) {
        $availableLetters = $letters;
        [$x1, $y1] = $path[$i];
        [$x2, $y2] = $path[$end - $i];

        error_log("i is $i ($x1 $y1) & ($x2 $y2)");

        foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) {
            $xu = $x1 + $xm;
            $yu = $y1 + $ym;

            unset($availableLetters[$grid[$yu][$xu] ?? '*']);

            $xu = $x2 + $xm;
            $yu = $y2 + $ym;

            unset($availableLetters[$grid[$yu][$xu] ?? '*']);
        }

        error_log("using " . array_key_first($availableLetters));

        $grid[$y1][$x1] = $grid[$y2][$x2] = array_key_first($availableLetters);

        error_log(var_export(implode(PHP_EOL, $grid), 1));
    }

    return $grid;
}

function findPath(array $path, array $visited, int $count): ?array {
    global $neighbors, $N, $half;

    if($count == $N * $N) return $path;

    foreach($neighbors[array_key_last($visited)] as $neighbor => $_) {
        if(isset($visited[$neighbor])) continue;
        if($count > $half && isset($neighbors[$path[$N * $N - $count - 1]][$neighbor])) continue;

        $path[$count] = $neighbor;
        $visited[$neighbor] = 1;

        $result = findPath($path, $visited, $count + 1);
        
        if($result !== null) return $result;

        unset($visited[$neighbor]);
    }

    return null;
}

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d %d", $startR, $startC);

$startTime = microtime(1);
$start = ($startR - 1) * $N + $startC - 1;
$neighbors = [];
$half = ($N * $N) / 2;

for($y = 0, $index = 0; $y < $N; ++$y) {
    for($x = 0; $x < $N; ++$x, ++$index) {
        if($x > 0) $neighbors[$index][$index - 1] = 1;
        if($x < $N - 1) $neighbors[$index][$index + 1] = 1;
        if($y > 0) $neighbors[$index][$index - $N] = 1;
        if($y < $N - 1) $neighbors[$index][$index + $N] = 1;
    }
}

error_log(var_export("Start is $start", true));
// error_log(var_export($neighbors, true));

$path = findPath([$start], [$start => 1], 1);

error_log(microtime(1) - $startTime);

// error_log(var_export($path, 1));

$line = str_repeat("*", $N);
$grid = array_fill(0, $N, $line);

foreach($path as $i => $index) $grid[intdiv($index, $N)][$index % $N] = chr(65 + $i);

 error_log(var_export(implode(PHP_EOL, $grid), 1));
