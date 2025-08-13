<?php

// Get all the sections of a path, each time we switch from horizontal/vertical we start a new section
function getSections(array $path, int $color): array {
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

// We have linked all the colors, we get all the empty positions left.
function getEmptyPositions(string $grid): array {
    global $size, $neighbors;

    $groups = [];

    for($index = 0; $index < $size; ++$index) {
        // We found an empty position
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

            $groups[] = $group;
        }
    }

    return $groups;
}

function cleanPairs(array &$pairs, int $index, int $neighbor, array &$toCheck) {
    $toCheck[] = [min($index, $neighbor), max($index, $neighbor)];

    unset($pairs[$index]);
    unset($pairs[$neighbor]);

    foreach($pairs as $index2 => $filler) {
        if(isset($pairs[$index2][$neighbor])) {
            unset($pairs[$index2][$neighbor]);

            if(count($pairs[$index2]) == 1) cleanPairs($pairs, $index2, array_key_last($pairs[$index2]), $toCheck);
        } 
    } 
}

// We have connected all the colors but there are some positions that are not used, we try to add them to an existing path
function assignEmptyPositions(array $groups, string $grid, array $paths) {
    global $neighbors;

    //Get the next group we need to work on
    while (($groupID = array_key_last($groups)) !== null && count($groups[$groupID]) == 0) {
        unset($groups[$groupID]);
    }

    if ($groupID === null) return $paths;

    $pairs = [];
    $toCheck = [];
    $toCheck2 = [];

    // For each positions find all it's neighbors that are also not occupied
    foreach($groups[$groupID] as $index => $filler) {
        foreach($neighbors[$index] as $neighbor) {
            if($grid[$neighbor] == '.') $pairs[$index][$neighbor] = 1;
        }
    }

    // If a position only has one empty neighbor, the neighbor is forced to be associated with the position
    foreach($pairs as $index => &$list) {
        if(count($list) == 1) {
            cleanPairs($pairs, $index, array_key_first($list), $toCheck);
        }
    }

    foreach($pairs as $index1 => &$list) {
        foreach($list as $index2 => $filler) {
            if($index1 < $index2) $toCheck[] = [$index1, $index2];
        }
    }

    foreach($toCheck as [$index1, $index2]) {
        // Horizontal
        if($index2 - $index1 == 1) $dirs = ['U', 'D'];
        // Vertical
        else $dirs = ['L', 'R'];

        foreach($dirs as $dir) {
            $n1 = $neighbors[$index1][$dir] ?? null;
            $n2 = $neighbors[$index2][$dir] ?? null;

            if($n1 && $n2 && ($c1 = $grid[$n1]) == $grid[$n2] && ctype_digit($c1)) {
                
                $p1 = array_search($n1, $paths[$c1]);
                $p2 = array_search($n2, $paths[$c1]);

                if(abs($p1 - $p2) != 1) continue; //They don't follow each other in the path, we can't insert there

                $grid2 = $grid;
                $grid2[$index1] = $grid2[$index2] = $c1;

                $groups2 = $groups;
                unset($groups2[$groupID][$index1]);
                unset($groups2[$groupID][$index2]);

                $paths2 = $paths;
                array_splice($paths2[$c1], max($p1, $p2), 0, ($p1 < $p2 ? [$index1, $index2] : [$index2, $index1]));

                if(($solution = assignEmptyPositions($groups2, $grid2, $paths2))) return $solution;
            }
        }
    }

    return null;
}

// When we add empty positions to existing path we can only do it 2 by 2, if we have a group of odd size 
// and we are sure no positions will be occupied by another path we know we won't be able to assign all the empty positions.
function checkEmptyPositions(string $grid, array $colorsUsed): bool {
    global $size, $neighbors;

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
            
            if(ctype_digit($grid[$index2])) {
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
                if(!isset($colorsUsed[$color]) && $value == 2) continue 2;
            }

            return false;
        }
    }

    return true;
}

// We are search for a path to link all the colors, we don't care if all the positions are used or not
function findPaths(array $colors, string $grid, int $filled = 0, array $paths = []): bool {
    global $neighbors, $values, $size;

    $color = array_key_last($colors);

    // We have linked all the colors
    if($color === null) {
        //We have some positions that are not used by any paths
        if($size - $filled) {
            $groups = getEmptyPositions($grid);

            $paths = assignEmptyPositions($groups, $grid, $paths);

            if(!$paths) return false; // We could not assign all the positions to an existing path
        }

        foreach($paths as $color => $path) {
            foreach(getSections($path, $color) as $section) echo $section . PHP_EOL;
        }

        return true;
    }

    [$start, $end, ] = array_pop($colors);

    $pq = new SplPriorityQueue();

    $grid[$end] = '.';
     
    $pq->insert([$start, null, 0, 0, [$start => 1]], 0); 

    while (!$pq->isEmpty()) {
        [$index, $dir, $turns, $steps, $path] = $pq->extract();

        // We have connected the color
        if ($index == $end) {
            $paths[$color] = array_keys($path);
            $gridWithPath = $grid;

            foreach($paths[$color] as $index) $gridWithPath[$index] = $color;

            if(checkEmptyPositions($gridWithPath, array_flip(array_keys($paths)))) {
                if(findPaths($colors, $gridWithPath, $filled + count($path), $paths)) return true;
            }

            continue;
        }
        
        foreach ($neighbors[$index] as $ndir => $neighbor) {
            if ($grid[$neighbor] === '.') {
                if (!isset($path[$neighbor])) {
                    $newTurns = $turns + (($dir != $ndir) ? 1 : 0);
   
                    // PriorityQueue is max-heap, so use negative priority, we proritize paths with the less 'turns' 
                    $pq->insert([$neighbor, $ndir, $newTurns, $steps + 1, $path + [$neighbor => 1]], -($newTurns * 1000 + $steps));
                }
            }
        }
    }

    return false;
}

fscanf(STDIN, "%d %d", $h, $w);

$grid = "";
$index = 0;
$neighbors = [];
$size = $h * $w;
$start = microtime(1);

for ($y = 0; $y < $h; ++$y) {
    $line = stream_get_line(STDIN, $w + 1, "\n");

    foreach(str_split($line) as $x => $c) {
        if($c != '.') $colors[$c] = [];

        if($x > 0) $neighbors[$index]['L'] = $index - 1;
        if($x < $w - 1) $neighbors[$index]['R'] = $index + 1;
        if($y > 0) $neighbors[$index]['U'] = $index - $w;
        if($y < $h - 1) $neighbors[$index]['D'] = $index + $w;

        $coordinates[$index] = [$x, $y];

        ++$index;
    }   

    $grid .= $line;
}

error_log(var_export(str_split($grid, $w), 1));

//We search for the start & end of each colors and sort them by they there Manhattan distance
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

findPaths($colors, $grid);

error_log(microtime(1) - $start);
