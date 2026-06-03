<?php

function getIndex(string $position): int {
    return (8 - $position[1]) * 8 + ord($position[0]) - 97;
}

$grid = str_repeat('.', 64);
$index = 0;

foreach(str_split(trim(fgets(STDIN))) as $c) {
    if($c == '/') continue;
    elseif(ctype_digit($c)) $index += $c;
    else {
        $grid[$index++] = $c;
    }
}

error_log(var_export(str_split($grid, 8), 1));

$moves = [];

for($i = 0, $n = intval(fgets(STDIN)); $i < $n; ++$i) {
    $input = trim(fgets(STDIN));

    $i1 = getIndex(substr($input, 0, 2));
    $i2 = getIndex(substr($input, 2, 4));
    $piece = $grid[$i1];

    //Castling
    if(strcasecmp($piece, 'k') == 0 && abs($i1 - $i2) == 2) {
        if($i1 < $i2) {
            $grid[$i2 - 1] = ($piece === 'K' ? 'R' : 'r');
            //Remove the rook
            for($j = $i2 + 1; ; ++$j) {
                if(strcasecmp($grid[$j], 'r') === 0) {
                    $grid[$j] = '.';
                    break;
                }
            }
        } else {
            $grid[$i2 + 1] = ($piece === 'K' ? 'R' : 'r');
            //Remove the rook
            for($j = $i2 - 1; ; --$j) {
                if(strcasecmp($grid[$j], 'r') === 0) {
                    $grid[$j] = '.';
                    break;
                }
            }
        }
    } 
    //En passant
    if($i > 0 && strcasecmp($piece, 'p') == 0 && strcasecmp($moves[$i - 1][0], 'p') == 0 && abs($moves[$i - 1][1] - $moves[$i - 1][2]) == 16) {
        if($moves[$i - 1][1] > $moves[$i - 1][2] && $i2 == $moves[$i - 1][1] - 8) $grid[$moves[$i - 1][2]] = '.';
        if($moves[$i - 1][1] < $moves[$i - 1][2] && $i2 == $moves[$i - 1][1] + 8) $grid[$moves[$i - 1][2]] = '.';
    }

    $grid[$i2] = $grid[$i1];
    $grid[$i1] = '.';

    //Promotion
    if($grid[$i2] == "P" && $i2 < 8) $grid[$i2] = $input[4];
    if($grid[$i2] == "p" && $i2 > 55) $grid[$i2] = $input[4];

    $moves[$i] = [$piece, $i1, $i2];
}

$output = [];

foreach(str_split($grid, 8) as $y => $line) {
    $output[] = preg_replace_callback('/\.+/',
        function ($matches) {
            return strlen($matches[0]);
        }, $line);
}

echo implode('/', $output);
