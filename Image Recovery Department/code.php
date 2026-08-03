<?php

function rotate(int $r, int $c, int $s, int $times, array $arr): array {
    $xs = $c - $s;
    $ys = $r - $s;
    $l = $s * 2 + 1;

    $temp = $arr;

    for($y = 0; $y < $l; ++$y) {
        for($x = 0; $x < $l; ++$x) {
            switch($times) {
                case 1: //90° CW - (y, x) -> (x, L-1-y)
                    $temp[$ys + $x][$xs + $l - 1 - $y] = $arr[$ys + $y][$xs + $x];
                    break;
                case 2: //180° - (y, x) -> (L-1-y, L-1-x)
                    $temp[$ys + + $l - 1 - $y][$xs + $l - 1 - $x] = $arr[$ys + $y][$xs + $x];
                    break;
                case 3: //270 CW or 90° CCW - (y, x) -> (L-1-x, y)
                    $temp[$ys + $l - 1 - $x][$xs + $y] = $arr[$ys + $y][$xs + $x];
                    break;
                case 0:
                case 4:
                    break;
                default:
                    throw new Exception("Invalid Number Of Turns");
            }
        }
    }

    return $temp;
}

fscanf(STDIN, "%d %d", $h, $w);
fscanf(STDIN, "%d", $logLength);

$entries = explode("  ", trim(fgets(STDIN)));

$image = [];
for($y = 0; $y < $h; ++$y) {
    $line = stream_get_line(STDIN, $w + 1, "\n");
    error_log($line);
    $image[] = $line;
}

for($i = $logLength - 1; $i >= 0; --$i){
    [$r, $c, $t, $s] = explode(" ", $entries[$i]);

    $t = ((-$t) % 4 + 4) % 4;

    $image = rotate($r, $c, $s, $t, $image);
}

echo implode(PHP_EOL, $image);
