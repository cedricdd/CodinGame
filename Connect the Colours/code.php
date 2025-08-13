<?php

function getSections(array $path, int $color): array {
    global $coordinates;

    $sections = [];

    $xs = null;
    $ys = null;
    $ex = null;
    $ey = null;

    // error_log(var_export($path, 1));

    foreach($path as $index) {
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

function checkEmptyPositions(string $grid): array {
    global $size, $neighbors;

    $groups = [];

    for($index = 0; $index < $size; ++$index) {
        if($grid[$index] == '.') {
            $queue = [$index];
            $group = [];

            while($queue) {
                $index2 = array_pop($queue);

                if($grid[$index2] != '.') continue;
                else $grid[$index2] = '#';

                $group[$index2] = 1;

                foreach($neighbors[$index2] as $neighbor) {
                    if($grid[$neighbor] == '.') $queue[] = $neighbor;
                }
            }

            $count = count($group);

            // error_log("we have a $count empty zone");

            if($count % 2 != 0) return [];

            $groups[] = $group;
        }
    }

    return $groups;
}

function cleanPairs(array &$pairs, int $index, int $neighbor) {
    $pairs[$neighbor] = [$index => 1];

    foreach($pairs as $index2 => $filler) {
        if($index2 == $index || $index2 == $neighbor) continue;

        if(isset($pairs[$index2][$neighbor])) {
            unset($pairs[$index2][$neighbor]);

            if(count($pairs[$index2]) == 1) cleanPairs($pairs, $index2, array_key_last($pairs[$index2]));
        } 
    } 
}

function assignEmptyPositions(array $groups, string $grid, array $paths) {
    global $neighbors;
    static $calls = 0;

    // error_log("calls: " . (++$calls));

    while(true) {
        $groupID = array_key_last($groups);

        if($groupID === null) return $paths;

        if(count($groups[$groupID]) == 0) unset($groups[$groupID]);
        else break;
    }

    $pairs = [];
    $toCheck = [];
    $toCheck2 = [];

    foreach($groups[$groupID] as $index => $filler) {
        foreach($neighbors[$index] as $neighbor) {
            if($grid[$neighbor] == '.') $pairs[$index][$neighbor] = 1;
        }
    }

    foreach($pairs as $index => &$list) {
        if(count($list) == 1) {
            cleanPairs($pairs, $index, array_key_first($list));
        }
    }

    // error_log(var_export($pairs, 1));

    foreach($pairs as $index1 => &$list) {
        if(count($list) == 1) {
            $index2 = array_key_last($list);

            $toCheck[] = [min($index1, $index2), max($index1, $index2)];

            unset($pairs[$index1]);
            unset($pairs[$index2]);
        } else {
            foreach($list as $index2 => $filler) {
                if($index1 < $index2) $toCheck2[] = [$index1, $index2];
            }
        }
    }

    $toCheck += $toCheck2;

    // error_log(var_export($toCheck, 1));

    foreach($toCheck as [$index1, $index2]) {
        if($grid[$index1] != '.' || $grid[$index2] != '.') continue;

        // Horizontal
        if($index2 - $index1 == 1) $dirs = ['U', 'D'];
        // Vertical
        else $dirs = ['L', 'R'];

        // error_log("working on $index1 & $index2");

        foreach($dirs as $dir) {
            if(isset($neighbors[$index1][$dir]) && isset($neighbors[$index2][$dir]) && ($c1 = $grid[$neighbors[$index1][$dir]]) == ($c2 = $grid[$neighbors[$index2][$dir]]) && ctype_digit($c1)) {
                
                $p1 = array_search($neighbors[$index1][$dir], $paths[$c1]);
                $p2 = array_search($neighbors[$index2][$dir], $paths[$c1]);

                if(abs($p1 - $p2) != 1) continue;

                $grid2 = $grid;
                $grid2[$index1] = $grid2[$index2] = $c1;

                $groups2 = $groups;
                unset($groups2[$groupID][$index1]);
                unset($groups2[$groupID][$index2]);

                // error_log("we can add them to $c1 - $p1 $p2");

                $paths2 = $paths;
                array_splice($paths2[$c1], max($p1, $p2), 0, ($p1 < $p2 ? [$index1, $index2] : [$index2, $index1]));

                if(($solution = assignEmptyPositions($groups2, $grid2, $paths2)) != null) return $solution;
            }
        }
    }

    return null;
}

function test(string $grid, array $colorsUsed): bool {
    global $size, $neighbors, $w;

    // error_log("TEST");
    // error_log(var_export(str_split($grid, $w), 1));
    // error_log(var_export($colorsUsed, 1));

    for($index = 0; $index < $size; ++$index) {
        if($grid[$index] == '.') {
            // error_log("start at $index");

            $count = 0;
            $colors = [];
            $visited = [];
            $queue = [$index];

            while($queue) {
                $index2 = array_pop($queue);

                if(isset($visited[$index2])) continue;

                $visited[$index2] = true;
                
                if(ctype_digit($grid[$index2])) {
                    // error_log("we found: {$grid[$index2]}");
                    $colors[$grid[$index2]] = ($colors[$grid[$index2]] ?? 0) + 1;

                    continue;
                } else {
                    ++$count;
                    $grid[$index2] = '#';
                }
                
                foreach($neighbors[$index2] as $neighbor) $queue[] = $neighbor;
            }

            if($count & 1) {
                foreach($colors as $color => $value) {
                    if(array_search($color, $colorsUsed) === false && $value == 2) continue 2;
                }

                return false;
            }
        }
    }

    return true;
}

function findPaths(array $colors, string $grid, int $filled = 0, array $paths = []): bool {
    global $neighbors, $values, $size;

    $color = array_key_last($colors);

    if($color === null) {
        // error_log(var_export($paths, 1));

        // error_log("We have a solution, there are " . ($size - $filled) . " empty left.");

        if($size - $filled) {
            $groups = checkEmptyPositions($grid);

            if(!$groups) return false;

            $paths = assignEmptyPositions($groups, $grid, $paths) ?? $paths;
        }

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
            $paths[$color] = array_keys($path);
            $gridWithPath = $grid;

            foreach($paths[$color] as $index) $gridWithPath[$index] = $color;

            if(test($gridWithPath, array_keys($paths))) {
                if(findPaths($colors, $gridWithPath, $filled + count($path), $paths)) return true;
            }

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
$empty = 0;

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
