<?php

// Get all the sections of a path, each time we switch from horizontal/vertical we start a new section
function getSections(array $path, string $color): array {
    global $coordinates;

    $sections = [];

    $xs = null;
    $ys = null;
    $ex = null;
    $ey = null;

    foreach($path as $index) {
        [$x, $y] = $coordinates[$index];

        // First position
        if($xs === null || $ys === null) [$xs, $ys] = [$x, $y];

        // We need to 'turn'
        if($x != $xs && $y != $ys) {
            $sections[] = "$xs $ys $ex $ey $color";
            [$xs, $ys] = [$ex, $ey];
        } 
        
        [$ex, $ey] = [$x, $y];
    }

    $sections[] = "$xs $ys $ex $ey $color"; // Add the last section to the final position

    return $sections;
}

// When we add empty positions to existing path we can only do it 2 by 2, if we have a group of odd size 
// and we are sure no positions will be occupied by another path we know we won't be able to assign all the empty positions.
function checkEmptyPositions(string $grid, array $colorsUsed): bool {
    global $size, $neighbors, $w;

    error_log(var_export(str_split($grid, $w), 1));

    for($index = 0; $index < $size; ++$index) {
        if ($grid[$index] !== '.') continue;
        
        $count = 0;
        $colors = [];
        $visited = [];
        $queue = [$index];

        while($queue) {
            $index2 = array_pop($queue);

            if(isset($visited[$index2])) continue;

            $visited[$index2] = true;
            
            if($grid[$index2] == '.') {
                ++$count;
                $grid[$index2] = '#';
            } elseif($grid[$index2] != 'X') {
                $colors[$grid[$index2]] = ($colors[$grid[$index2]] ?? 0) + 1;

                continue;
            }
            
            foreach($neighbors[$index2] as $neighbor) $queue[] = $neighbor;
        }

        error_log("starting at $index we have $count");

        if($count & 1) {
            foreach($colors as $color => $value) {
                if(!isset($colorsUsed[$color]) && $value == 2) continue 2;
            }

            return false;
        }
    }

    return true;
}

// We are search for a path to link all the colors, we don't care if all the positions are used or not
function findPaths(array $colors, string $grid, int $filled = 0, array $paths = []): bool {
    global $neighbors, $size;

    $color = array_key_last($colors);

    // We have linked all the colors
    if($color === null) {
        error_log(var_export($paths, 1));

        foreach($paths as $color => $path) {
            foreach(getSections($path, $color) as $section) echo $section . PHP_EOL;
        }

        return true;
    }

    $color = strval($color);
    [$count, $start, $end] = $colors[$color];

    error_log("For $color we start at $start and we need $count");

    $pq = new SplPriorityQueue();
    $pq->insert([$start, null, 0, 0, 0, [$start => 1]], 0); 

    while (!$pq->isEmpty()) {
        [$index, $dir, $turns, $steps, $occ, $path] = $pq->extract();

        if($grid[$index] == $color) ++$occ;
        
        // We have connected the color
        if($index == $end && $occ == $count) {
            // error_log("at $index we found $color");
            
            $paths[$color] = array_keys($path);
            $gridWithPath = $grid;

            unset($colors[$color]);
            
            error_log("$color: " . implode("-", array_keys($path)));
            
            foreach($paths[$color] as $index) $gridWithPath[$index] = $color;

            if(checkEmptyPositions($gridWithPath, array_flip(array_keys($paths)))) {
                if(findPaths($colors, $gridWithPath, $filled + count($path), $paths)) return true;
            } else error_log("bad check empty");

            continue;
        }
        
        foreach ($neighbors[$index] as $ndir => $neighbor) {
            if ($grid[$neighbor] === '.' || $grid[$neighbor] === $color) {
                if (!isset($path[$neighbor])) {
                    $newTurns = $turns + (($dir != $ndir) ? 1 : 0);
   
                    // PriorityQueue is max-heap, so use negative priority, we proritize paths with the less 'turns' 
                    $pq->insert([$neighbor, $ndir, $newTurns, $steps + 1, $occ, $path + [$neighbor => 1]], -($newTurns * 1000 + $steps));
                }
            }
        }
    }

    return false;
}

fscanf(STDIN, "%d %d", $h, $w);

$grid = [];
$index = 0;
$neighbors = [];
$size = 0;
$start = microtime(1);

for ($y = 0; $y < $h; ++$y) {
    $grid[$y] = stream_get_line(STDIN, $w + 1, "\n");

    foreach(str_split($grid[$y]) as $x => $c) {
        $index = $y * $w + $x;

        if($c != '.' && $c != 'H' && $c != 'V' && $c != 'X' && !isset($colors[$c])) $colors[$c] = [2, $index];
        if($c != 'X') ++$size;
        if($c == 'V') {
            $V[$index] = 1;
            $grid[$y][$x] = '.';
        } 
        if($c == 'H') {
            $H[$index] = 1;
            $grid[$y][$x] = '.';
        }

        $coordinates[$index] = [$x, $y];
    }
}

error_log(var_export($grid, 1));

$grid = implode('', $grid);

//We search for the start & end of each colors and sort them by they there Manhattan distance
foreach($colors as $id => [$count, $sp]) {
    $val = strval($id);

    $ep = strpos($grid, $val, $sp + 1);

    [$xs, $ys] = [$sp % $w, intdiv($sp, $w)];
    [$xe, $ye] = [$ep % $w, intdiv($ep, $w)];

    $distance = abs($xs - $xe) + abs($ys - $ye);

    $colors[$id] = [$count, $sp, $ep, $distance];
}

uasort($colors, function($a, $b) {
    return $a[3] <=> $b[3];
});

fscanf(STDIN, "%d", $k);
for ($i = 0; $i < $k; $i++) {
    fscanf(STDIN, "%d %d %s", $x, $y, $c);

    $grid[$y * $w + $x] = $c;
    $colors[$c][0]++;
}

for($index = ($w * $h) - 1; $index >= 0; --$index) {
    $c = $grid[$index];
    [$x, $y] = $coordinates[$index];

    if($x > 0) {
        $leftIndex = $index - 1;
        $left = $grid[$leftIndex];
        
        if($left != 'X' && !isset($V[$left]) &&  !isset($V[$index]) && (!isset($colors[$c]) || !isset($colors[$left]) || $c == $left)) $neighbors[$index]['L'] = $leftIndex;
    }
    if($x < $w - 1) {
        $rightIndex = $index + 1;
        $right = $grid[$rightIndex];

        if($right != 'X' && !isset($V[$right]) && !isset($V[$index]) && (!isset($colors[$c]) || !isset($colors[$right]) || $c == $right)) $neighbors[$index]['R'] = $rightIndex;
    }
    if($y > 0) {
        $upIndex = $index - $w;
        $up = $grid[$upIndex];
        
        if($up != 'X' && !isset($H[$up]) && !isset($H[$index]) && (!isset($colors[$c]) || !isset($colors[$up]) || $c == $up)) $neighbors[$index]['U'] = $upIndex;
    }
    if($y < $h - 1) {
        $downIndex = $index + $w;
        $down = $grid[$downIndex];

        if($down != 'X' && !isset($H[$downIndex]) && !isset($H[$index]) && (!isset($colors[$c]) || !isset($colors[$down]) || $c == $down)) $neighbors[$index]['D'] = $downIndex;
    }
}

error_log(var_export($colors, 1));
// error_log(var_export($H, 1));
// error_log(var_export($neighbors, 1));

findPaths($colors, $grid);
