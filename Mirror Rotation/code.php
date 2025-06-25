<?php

const MOVES = ['N' => [0, -1], 'S' => [0, 1], 'E' => [1, 0], 'W' => [-1, 0]];
const REFLECTION = [
    0 => ['N' => 'E', 'E' => 'N', 'S' => 'W', 'W' => 'S'],
    1 => ['N' => 'W', 'W' => 'N', 'S' => 'E', 'E' => 'S'],
];

function explore(int $x, int $y, string $dir, array $visited = [], array $flips = []): void {
    global $room, $bestCount, $bestFlips, $w, $h;

    if(count($flips) + 1 >= $bestCount) return;

    error_log("at $x $y - $dir " . implode("-", array_keys($flips)));

    if(isset($visited[$y][$x])) return;
    else $visited[$y][$x] = 1;

    while(true) {
        $x += MOVES[$dir][0];
        $y += MOVES[$dir][1];

        if($x < 0 || $x >= $w || $y < 0 || $y >= $h) {
            // error_log("break 1");
            break;
        }

        if($room[$y][$x] == 'T') {
            error_log("reached target");
            $bestCount = count($flips);
            $bestFlips = $flips;

            break;
        }

        if($room[$y][$x] == '#') {
            // error_log("break 2");
            break;
        }

        if(ctype_digit($room[$y][$x])) {
            $v = intval($room[$y][$x]);

            explore($x, $y, REFLECTION[$v][$dir], $visited, $flips); 
            if(!isset($flips["$x $y"])) explore($x, $y, REFLECTION[($v + 1) % 2][$dir], $visited, $flips + ["$x $y" => 1]);   

            // error_log("break 3");

            break;
        }
    }
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $w, $h);

for ($y = 0; $y < $h; ++$y) {
    $line = trim(fgets(STDIN));
    $line = strtr($line, "/\\", "01");

    if(($x = strpos($line, 'L')) !== false) {
        $xs = $x;
        $ys = $y;
    }

    $room[] = $line;
}

fscanf(STDIN, "%s", $dir);

error_log(var_export($room, 1));
error_log(var_export($dir, 1));

$bestCount = INF;
$bestFlips = [];

explore($xs, $ys, $dir);

uksort($bestFlips, function($a, $b) {
    [$xa, $ya] = explode(" ", $a);
    [$xb, $yb] = explode(" ", $b);

    if($ya == $yb) return $xa <=> $xb;
    else return $ya <=> $yb;
});

error_log($bestCount);
echo implode(PHP_EOL, array_keys($bestFlips)) . PHP_EOL;

error_log(microtime(1) - $start);
