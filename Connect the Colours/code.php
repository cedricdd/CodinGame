<?php

function findHamiltonianPath(string $grid, int $start, int $end, int $goal) {
    global $neighbors, $size;

    // $visited = array_fill(0, $rows, array_fill(0, $cols, false));
    $path = [];
    $grid[$end] = '.';

    $dfs = function(int $position, int $count) use (&$dfs, &$path, &$neighbors, $grid, $end, $goal, $size) {
        $path[$position] = 1;
        ++$count;

        // error_log("we are at $position with $count");

        if ($position === $end) {
            if ($count === $goal) {
                return true; // Found valid path
            }

            error_log("backtrack - end too early");

            // Can't continue if reached end too early
            array_pop($path);
            return false;
        }

        $start = null;

        for ($index = 0; $index < $size; ++$index) {
            if (!isset($path[$index]) && $grid[$index] == ".") {
                $start = $index;
                break;
            }
        }

        $countEmpty = 0;
        $queue = [$start];
        $gridFlood = $grid;

        while ($queue) {
            $index = array_pop($queue);

            if($gridFlood[$index] != '.') continue;
            else $gridFlood[$index] = '#';

            $countEmpty++;

            // error_log("adding $index");

            foreach ($neighbors[$index] as $neighbor) {
                if ($gridFlood[$neighbor] == '.' && !isset($path[$neighbor])) {
                    $queue[] = $neighbor;
                }
            }
        }

        if ($countEmpty != ($goal - $count)) {
            error_log("backtrack is connected - $countEmpty != " . ($goal - $count));

            array_pop($path);
            return false;
        }

        // Order neighbors by Warnsdorff's rule
        $possibilities = [];

        foreach ($neighbors[$position] as $neighbor) {

            if (!isset($path[$neighbor]) && $grid[$neighbor] === '.') {

                $possibilities[$neighbor] = 0;

                foreach ($neighbors[$neighbor] as $neighbor2) {
                    if (!isset($path[$neighbor2]) && $grid[$neighbor2] === '.') ++$possibilities[$neighbor];
                }
            }
        }
        uasort($possibilities, function($a, $b) {
            return $a <=> $b;
        });

        foreach ($possibilities as $neighbor => $filler) {
            if ($dfs($neighbor, $count)) {
                return true;
            }
        }

        error_log("backtrack");

        // Backtrack
        array_pop($path);
        return false;
    };

    if ($dfs($start, 0)) {
        return $path;
    }

    return null;
}

function getSections(array $path, int $color): array {
    global $coordinates;

    $sections = [];

    $xs = null;
    $ys = null;
    $ex = null;
    $ey = null;

    error_log(var_export($path, 1));

    foreach($path as $index => $filler) {
        [$x, $y] = $coordinates[$index];

        // error_log("at $x $y");

        if($xs === null || $ys === null) [$xs, $ys] = [$x, $y];

        if($x != $xs && $y != $ys) {
            // error_log("$x != $xs && $y != $ys");

            $sections[] = "$xs $ys $ex $ey $color";
            [$xs, $ys] = [$ex, $ey];
        } 
        
        [$ex, $ey] = [$x, $y];
    }

    $sections[] = "$xs $ys $ex $ey $color";

    return $sections;
}

function findPaths(array $colors, string $grid, array $paths = []): bool {
    global $neighbors, $values;

    $color = array_key_last($colors);

    if($color === null) {
        // error_log(var_export($paths, 1));

        foreach($paths as $color => $path) {
            foreach(getSections($path, $color) as $section) echo $section . PHP_EOL;
        }

        return true;
    }

    [$start, $end, ] = array_pop($colors);

    $pq = new SplPriorityQueue();

    // visited[i][dir] = min turns to reach
    $hashes = [];
    $grid[$end] = '.';
     
    $pq->insert([$start, null, 0, 0, 0, [$start => 1]], 0); 

    while (!$pq->isEmpty()) {
        [$index, $dir, $turns, $steps, $hash, $path] = $pq->extract();

        // error_log("$index $dir - $turns $steps");
        
        if ($index == $end) {
            // error_log(var_export($path, 1));
            $paths[$color] = $path;
            $gridWithPath = $grid;

            foreach($path as $index => $filler) $gridWithPath[$index] = '#';

            if(findPaths($colors, $gridWithPath, $paths)) return true;

            continue;
        }
        
        foreach ($neighbors[$index] as $ndir => $neighbor) {
            if ($grid[$neighbor] === '.') {
                if (!isset($path[$neighbor])) {
                    $newTurns = $turns + (($dir != $ndir) ? 1 : 0);
                    $newHash = $hash | ($values[$neighbor] ?? 0);
   
                    // PriorityQueue is max-heap, so use negative priority
                    $pq->insert([$neighbor, $ndir, $newTurns, $steps + 1, $newHash, $path + [$neighbor => 1]], -($newTurns * 1000 + $steps));
                }
            }
        }
    }

    return false;
}

$grid = "";
$index = 0;
$indexHash = 0;
$neighbors = [];

fscanf(STDIN, "%d %d", $h, $w);

$size = $h * $w;

$start = microtime(1);

for ($y = 0; $y < $h; ++$y) {
    $line = stream_get_line(STDIN, $w + 1, "\n");

    foreach(str_split($line) as $x => $c) {
        if($c == '.') {
            $values[$index] = 2 ** $indexHash;
            ++$indexHash;
        } else $colors[$c] = [];

        if($x > 0) $neighbors[$index]['L'] = $index - 1;
        if($x < $w - 1) $neighbors[$index]['R'] = $index + 1;
        if($y > 0) $neighbors[$index]['U'] = $index - $w;
        if($y < $h - 1) $neighbors[$index]['D'] = $index + $w;

        $coordinates[$index] = [$x, $y];

        ++$index;
    }   

    $grid .= $line;
}

error_log(var_export($grid, 1));
// error_log(var_export($coordinates, 1));

foreach($colors as $id => &$info) {
    $val = strval($id);
    $sp = strpos($grid, $val);
    $ep = strpos($grid, $val, $sp + 1);

    [$xs, $ys] = [$sp % $w, intdiv($sp, $w)];
    [$xe, $ye] = [$ep % $w, intdiv($ep, $w)];

    $distance = abs($xs - $xe) + abs($ys - $ye);

    $info = [$sp, $ep, $distance];
}

uasort($colors, function($a, $b) {
    return $a[2] <=> $b[2];
});

// error_log(var_export($colors, 1));

findPaths($colors, $grid);

error_log(microtime(1) - $start);
