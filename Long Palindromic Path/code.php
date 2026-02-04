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

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d %d", $startR, $startC);

// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug: error_log(var_export($var, true)); (equivalent to var_dump)

$path = [
    [0, 0],
    [1, 0],
    [2, 0],
    [3, 0],
    [3, 1],
    [2, 1],
    [1, 1],
    [0, 1],
    [0, 2],
    [0, 3],
    [1, 3],
    [1, 2],
    [2, 2],
    [3, 2],
    [3, 3],
    [2, 3],
];

echo("4 3\n");
// echo("abcd\n");
// echo("hgfe\n");
// echo("hedc\n");
// echo("gfab\n");

$grid = setLetters($path, $N);

echo implode(PHP_EOL, $grid) . PHP_EOL;
