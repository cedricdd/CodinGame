<?php

function LCG(): int {
    static $a = 330;
    static $m = 254803967;
    static $c = 100;
    global $seed;
    
    return $seed = ((($a * $seed) & 4294967295) + $c) % $m;
}

fscanf(STDIN, "%d", $seed);

$width = (LCG() % 31) + 11;
$height = (LCG() % 31) + 11;

$line = str_repeat("#", $width);
$grid = array_fill(0, $height, $line);

// echo implode(PHP_EOL, $grid) . PHP_EOL;

error_log("$width - $height");

$visited = [];
$grid[0][0] = '.';
$walls = [[1, 0], [0, 1]];

while($walls) {
    $walls = array_values($walls);

    $index = LCG() % count($walls);
    [$x, $y] = $walls[$index];
    $passable = 0;

    error_log($index . " ($x $y) - " . count($walls) . " - " . $seed);
    error_log(var_export(array_map(function($l) {
        return "(" . $l[0] . ", " . $l[1] . ")";
    }, $walls), 1));

    $neighbours = [];

    foreach([[0, -1], [1, 0], [0, 1], [-1, 0]] as [$xm, $ym]) {
        $xu = $x + $xm;
        $yu = $y + $ym;

        if($xu >= 0 && $xu < $width && ($xu % 2) == 0 && $yu >= 0 && $yu < $height && ($yu % 2) == 0) {
            $neighbours[] = [$xu, $yu];
            $passable += ($grid[$yu][$xu] == '.') ? 1 : 0;
        }
    }

    // if($index == 7) error_log(var_export($neighbours, 1));

    if($passable == 1) {
        error_log("only one");
        // error_log(var_export($neighbours, 1));

        //Make the wall passable
        $grid[$y][$x] = '.';

        foreach($neighbours as [$xn, $yn]) {
            if($grid[$yn][$xn] == '#') {
                error_log("$xn-$yn");

                $grid[$yn][$xn] = '.';

                foreach([[0, -1], [1, 0], [0, 1], [-1, 0]] as [$xm, $ym]) {
                    $xu = $xn + $xm;
                    $yu = $yn + $ym;
            
                    if($xu >= 0 && $xu < $width && $yu >= 0 && $yu < $height && $grid[$yu][$xu] == '#') {
                        $walls[] = [$xu, $yu];
                    }
                }

                break;
            }
        }
    }

    unset($walls[$index]);
}

echo implode(PHP_EOL, $grid) . PHP_EOL;
