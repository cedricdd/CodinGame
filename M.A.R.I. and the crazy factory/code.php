<?php

//0 north 1 east 2 south 3 west
const MOVES = [[0, -1], [1, 0], [0, 1], [-1, 0]];

function applyInstruction(int $x, int $y, string $d, array $instructions): array {
    global $map;

    foreach($instructions as $instruction) {
        if($instruction == "p1") {
            $x += MOVES[$d][0];
            $y += MOVES[$d][1];

            if(($map[$y][$x] ?? '#') == '#') return [-1, -1, ''];
        } elseif($instruction == "p2") {
            for($i = 0; $i < 2; ++$i) {
                $x += MOVES[$d][0];
                $y += MOVES[$d][1];

                if(($map[$y][$x] ?? '#') == '#') return [-1, -1, ''];
            }
        }
        elseif($instruction == "tl") $d = ($d - 1 + 4) % 4;
        elseif($instruction == "tr") $d = ($d + 1) % 4;
    }

    return [$x, $y, $d];
}

function solve(int $xs, int $ys, string $ds, array $ins, string $list = "") {
    global $xd, $yd, $start;
    static $history = [];

    if($xs == $xd && $ys == $yd) {
        error_log(microtime(1) - $start);
        error_log(trim($list));
        return;
    }

    $count = count($ins);

    if(isset($history[$ys][$xs][$ds]) && $history[$ys][$xs][$ds] <= $count) {
        error_log("history for $xs $ys $ds");
        return;
    }
    else $history[$ys][$xs][$ds] = $count;

    for($i = 0; $i <= $count; ++$i) {
        foreach(["p1", "p2", "tr"] as $instruction) {
            $insUpdated = $ins;
            array_splice($insUpdated, $i, 0, $instruction);

            // error_log(var_export($insUpdated, true));

            [$x, $y, $d] = applyInstruction($xs, $ys, $ds, $insUpdated);

            if($x != -1 && $y != 1) {
                solve($x, $y, $d, $insUpdated, $list . " " . implode(" ", $insUpdated));
            }
        }
    }
}

$start = microtime(1);

$ins = stream_get_line(STDIN, 40 + 1, "\n");

if($ins[0] == ' ') $ins = []; //We don't care about these instructions
else {
    $ins = explode(" ", $ins);
    $ins = array_slice($ins, 0, 1);
}

error_log(var_export($ins, true));

for ($y = 0; $y < 7; ++$y) {
    $line = trim(fgets(STDIN));

    error_log($line);

    foreach(str_split($line) as $x => $c) {
        $map[$y][$x] = $c;

        if(ctype_digit($c)) {
            $xs = $x;
            $ys = $y;
            $d = $c;
        } elseif($c == 'E') {
            $xd = $x;
            $yd = $y;
        }
    }
}

error_log("$xs $ys $d -- $xd $yd");

solve($xs, $ys, $d, $ins);
