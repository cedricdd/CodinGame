<?php

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

function setPositions(array $groups, string $grid, array $paths, int $groupID, string $color, array $positions, int $c1, int $c2) {
    $p1 = array_search($c1, $paths[$color]);
    $p2 = array_search($c2, $paths[$color]);

    if(abs($p1 - $p2) != 1) return null; //They don't follow each other in the path, we can't insert there

    foreach($positions as $position) {
        $grid[$position] = $color;

        unset($groups[$groupID][$position]);
    }

    array_splice($paths[$color], max($p1, $p2), 0, ($p1 < $p2 ? $positions : array_reverse($positions)));

    return assignEmptyPositions($groups, $grid, $paths);
}

// We have connected all the colors but there are some positions that are not used, we try to add them to an existing path
function assignEmptyPositions(array $groups, string $grid, array $paths) {
    global $neighbors, $V, $H, $w;

    //Get the next group we need to work on
    while (($groupID = array_key_last($groups)) !== null && count($groups[$groupID]) == 0) {
        unset($groups[$groupID]);
    }

    if ($groupID === null) return $paths;

    error_log("working on group ID $groupID");
    // error_log(var_export($groups[$groupID], 1));

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

    // error_log(var_export($toCheck, 1));

    foreach($toCheck as [$index1, $index2]) {
        error_log("wokring on $index1 - $index2 - " . count($groups[$groupID]));

        // Horizontal
        if($index2 - $index1 == 1) {
            if(isset($H[$index1])) {
                error_log("index1 is H");

                $p1 = $neighbors[$index1]['L'] ?? null;
                $index3 = $neighbors[$index2]['D'] ?? null;
                $index4 = $neighbors[$index3]['L'] ?? null;
                $p2 = $neighbors[$index4]['L'] ?? null;

                error_log("$index1 - $index2 -- $p1 - $p2 -- $index3 - $index4");

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index1, $index2, $index3, $index4], $p1, $p2))) return $solution;
                }
   
                continue;
            }
            if(isset($H[$index2])) {
                continue;
            }

            $dirs = ['U', 'D'];
        }
        // Vertical
        else $dirs = ['L', 'R'];

        foreach($dirs as $dir) {
            $p1 = $neighbors[$index1][$dir] ?? null;
            $p2 = $neighbors[$index2][$dir] ?? null;

            error_log("$p1 - $p2 - $dir");

            if($p1 && $p2 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.') {
                if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index1, $index2], $p1, $p2))) return $solution;
            }
        }
    }

    // error_log("end group ID $groupID");

    return null;
}

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

// When we add empty positions to existing path we can only do it 2 by 2, if we have a group of odd size 
// and we are sure no positions will be occupied by another path we know we won't be able to assign all the empty positions.
function checkEmptyPositions(string $grid, array $colorsUsed): bool {
    global $size, $neighbors, $w;

    // error_log(var_export(str_split($grid, $w), 1));

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

        // error_log("starting at $index we have $count");

        if($count & 1) {
            foreach($colors as $color => $value) {
                if(!isset($colorsUsed[$color]) && $value >= 2) continue 2;
            }

            return false;
        }
    }

    return true;
}

// We are search for a path to link all the colors, we don't care if all the positions are used or not
function findPaths(array $colors, string $grid, array $paths = []): bool {
    global $neighbors, $size;

    $color = array_key_last($colors);

    // We have linked all the colors
    if($color === null) {
        $groups = getEmptyPositions($grid);

        // error_log("Empty Groups:");
        // error_log(var_export($groups, 1));

        if(1 == 1 && $groups) {
            $paths2 = assignEmptyPositions($groups, $grid, $paths);

            if(!$paths2) {
                foreach($paths as $color => $path) {
                    foreach(getSections($path, $color) as $section) echo $section . PHP_EOL;
                }

                exit("Impossible to assign!!!!!!!");
                return false;
            } // We could not assign all the positions to an existing path
            else $paths = $paths2;
        }

        foreach($paths as $color => $path) {
            foreach(getSections($path, $color) as $section) echo $section . PHP_EOL;
        }

        return true;
    }

    $color = strval($color);
    [$count, $start, $end] = $colors[$color];

    // error_log("For $color we start at $start and we need $count");

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
            
            // error_log("$color: " . implode("-", array_keys($path)));
            
            foreach($paths[$color] as $index) $gridWithPath[$index] = $color;

            if(checkEmptyPositions($gridWithPath, array_flip(array_keys($paths)))) {
                if(findPaths($colors, $gridWithPath, $paths)) return true;
            } 
            // else error_log("bad check empty");

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

for($index = ($w * $h) - 1; $index >= 0; --$index) {
    $c = $grid[$index];
    [$x, $y] = $coordinates[$index];

    if($x > 0) {
        $leftIndex = $index - 1;
        $left = $grid[$leftIndex];
        
        if($left != 'X' && !isset($V[$leftIndex]) &&  !isset($V[$index]) && (!isset($colors[$c]) || !isset($colors[$left]) || $c == $left)) $neighbors[$index]['L'] = $leftIndex;
    }
    if($x < $w - 1) {
        $rightIndex = $index + 1;
        $right = $grid[$rightIndex];

        if($right != 'X' && !isset($V[$rightIndex]) && !isset($V[$index]) && (!isset($colors[$c]) || !isset($colors[$right]) || $c == $right)) $neighbors[$index]['R'] = $rightIndex;
    }
    if($y > 0) {
        $upIndex = $index - $w;
        $up = $grid[$upIndex];
        
        if($up != 'X' && !isset($H[$upIndex]) && !isset($H[$index]) && (!isset($colors[$c]) || !isset($colors[$up]) || $c == $up)) $neighbors[$index]['U'] = $upIndex;
    }
    if($y < $h - 1) {
        $downIndex = $index + $w;
        $down = $grid[$downIndex];

        if($down != 'X' && !isset($H[$downIndex]) && !isset($H[$index]) && (!isset($colors[$c]) || !isset($colors[$down]) || $c == $down)) $neighbors[$index]['D'] = $downIndex;
    }
}

fscanf(STDIN, "%d", $k);
for ($i = 0; $i < $k; $i++) {
    fscanf(STDIN, "%d %d %s", $x, $y, $c);

    $grid[$y * $w + $x] = $c;
    $colors[$c][0]++;
}

// $colors['e'][0]--;

// error_log(var_export($colors, 1));
// error_log(var_export($H, 1));
// error_log(var_export($neighbors, 1));

findPaths($colors, $grid);

error_log(microtime(1) - $start);
