<?php

const MOVES = ['N' => [0, -1], 'S' => [0, 1], 'E' => [1, 0], 'W' => [-1, 0]];
const REFLECTION = [
    0 => ['N' => 'E', 'E' => 'N', 'S' => 'W', 'W' => 'S'],
    1 => ['N' => 'W', 'W' => 'N', 'S' => 'E', 'E' => 'S'],
];

function explore(int $x, int $y, string $dir, array $visited = [], array $flips = []): void {
    global $room, $bestCount, $bestFlips, $w, $h;

    if(count($flips) >= $bestCount) return; // We can't find a better path

    if(isset($visited[$y][$x][$dir])) return; // We don't want to end up in a loop
    else $visited[$y][$x][$dir] = 1;

    while(true) {
        $x += MOVES[$dir][0];
        $y += MOVES[$dir][1];

        if($x < 0 || $x >= $w || $y < 0 || $y >= $h) break; // Out of the room

        if($room[$y][$x] == 'T') {
            $bestCount = count($flips);
            $bestFlips = $flips;

            break;
        }

        if($room[$y][$x] == '#') break; // Ended up in a wall

        if(ctype_digit($room[$y][$x])) {
            $v = intval($room[$y][$x]);

            explore($x, $y, REFLECTION[$v][$dir], $visited, $flips); // We continue without flipping

            // We continue after flipping
            if(!isset($visisted[$y][$y])) {
                $flips[] = [$x, $y];
                explore($x, $y, REFLECTION[($v + 1) % 2][$dir], $visited, $flips); 
            }

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

$bestCount = INF;
$bestFlips = [];

explore($xs, $ys, $dir);

// Sort by 'reading order'
usort($bestFlips, function($a, $b) {
    if($a[1] == $b[1]) return $a[0] <=> $b[0];
    else return $a[1] <=> $b[1];
});

echo implode(PHP_EOL, array_map(function($flip) { return implode(" ", $flip); }, $bestFlips)) . PHP_EOL;

error_log(microtime(1) - $start);
