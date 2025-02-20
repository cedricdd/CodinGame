<?php

function solve(string $hash, int $index): int {
    global $jumps;
    static $history = [];

    $longest = 0;
    $hash[$index] = '0';

    if(isset($history[$hash][$index])) return $history[$hash][$index];

    foreach($jumps[$index] ?? [] as $indexJump) {
        if($hash[$indexJump] == '1') {
            $result = 1 + solve($hash, $indexJump);

            if($result > $longest) $longest = $result;
        }
    }

    return $history[$hash][$index] = $longest;
}

$start = microtime(1);

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $pond[] = stream_get_line(STDIN, $n + 1, "\n");
}

error_log(var_export($pond, 1));

fscanf(STDIN, "%d", $xd);
fscanf(STDIN, "%d", $yd);

$hash = str_repeat('0', $n * $n);

//Pre-compute the possible jumps
for($y = 0, $index = 0; $y < $n; ++$y) {
    for($x = 0; $x < $n; ++$x, ++$index) {
        if($pond[$y][$x] == '#') {
            if($x > 0 && $pond[$y][$x - 1] == '#') $jumps[$index][] = $index - 1;
            if($x > 1 && $pond[$y][$x - 2] == '#') $jumps[$index][] = $index - 2;
            if($x < $n - 1 && $pond[$y][$x + 1] == '#') $jumps[$index][] = $index + 1;
            if($x < $n - 2 && $pond[$y][$x + 2] == '#') $jumps[$index][] = $index + 2;

            if($y > 0 && $pond[$y - 1][$x] == '#') $jumps[$index][] = $index - $n;
            if($y > 1 && $pond[$y - 2][$x] == '#') $jumps[$index][] = $index - (2 * $n);
            if($y < $n - 1 && $pond[$y + 1][$x] == '#') $jumps[$index][] = $index + $n;
            if($y < $n - 2 && $pond[$y + 2][$x] == '#') $jumps[$index][] = $index + (2 * $n);

            if($x > 0 && $y > 0 && $pond[$y - 1][$x - 1] == '#') $jumps[$index][] = $index - $n - 1;
            if($x < $n - 1 && $y > 0 && $pond[$y - 1][$x + 1] == '#') $jumps[$index][] = $index - $n + 1;
            if($x < $n - 1 && $y < $n - 1 && $pond[$y + 1][$x + 1] == '#') $jumps[$index][] = $index + $n + 1;
            if($x > 0 && $y < $n - 1 && $pond[$y + 1][$x - 1] == '#') $jumps[$index][] = $index + $n - 1;

            $hash[$index] = '1';
        }
    }
}

if($hash == str_repeat('1', $n * $n)) echo ($n * $n) . PHP_EOL; //We only have water lilies
else echo 1 + solve($hash, $yd * $n + $xd) . PHP_EOL;

error_log(microtime(1) - $start);
