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
    global $V, $H;

    //We can't add anything here becauses of a forced direction
    if(isset($V[$c1]) || isset($V[$c2]) || isset($H[$c1]) || isset($H[$c2])) return null;

    //Find the positions in the path
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

    $pairs = [];
    $toCheck = [];

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

    //Generate all the possible ways to assign empty positions
    foreach($pairs as $index1 => &$list) {
        foreach($list as $index2 => $filler) {
            //Skip the duplicates
            if($index1 < $index2) $toCheck[] = [$index1, $index2];
        }
    }

    foreach($toCheck as [$index1, $index2]) {
        // Horizontal
        if($index2 - $index1 == 1) {
            $dirs = ['U', 'D'];
            
            //$index1 is a forced horizontal direction
            if(isset($H[$index1])) {
                /**
                 * CH.
                 * C..
                 */

                $p1 = $neighbors[$index1]['L'] ?? null;
                $p2 = $neighbors[$p1]['D'] ?? null;
                $index4 = $neighbors[$p2]['R'] ?? null;
                $index3 = $neighbors[$index4]['R'] ?? null;
                
                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index1, $index2, $index3, $index4], $p1, $p2))) return $solution;
                }

                /**
                 * C..
                 * CH.
                 */
                $p1 = $neighbors[$index1]['L'] ?? null;
                $p2 = $neighbors[$p1]['U'] ?? null;
                $index4 = $neighbors[$p2]['R'] ?? null;
                $index3 = $neighbors[$index4]['R'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index1, $index2, $index3, $index4], $p1, $p2))) return $solution; 
                }

                /**
                 * .CC
                 * .H.
                 */
                $p2 = $neighbors[$index2]['U'] ?? null;
                $p1 = $neighbors[$p1]['L'] ?? null;
                $index3 = $neighbors[$p1]['L'] ?? null;
                $index4 = $neighbors[$index3]['D'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index3, $index4, $index1, $index2], $p1, $p2))) return $solution; 
                }

                /**
                 * .H.
                 * .CC
                 */
                $p2 = $neighbors[$index2]['D'] ?? null;
                $p1 = $neighbors[$p1]['L'] ?? null;
                $index3 = $neighbors[$p1]['L'] ?? null;
                $index4 = $neighbors[$index3]['U'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index3, $index4, $index1, $index2], $p1, $p2))) return $solution; 
                }

                continue;
            }

            //$index2 is a forced horizontal direction
            if(isset($H[$index2])) {
                /**
                 * .HC
                 * ..C
                 */
                $p1 = $neighbors[$index2]['R'] ?? null;
                $p2 = $neighbors[$p1]['U'] ?? null;
                $index3 = $neighbors[$p2]['L'] ?? null;
                $index4 = $neighbors[$index3]['L'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index2, $index1, $index4, $index3], $p1, $p2))) return $solution;
                }

                /**
                 * ..C
                 * .HC
                 */
                $p1 = $neighbors[$index2]['R'] ?? null;
                $p2 = $neighbors[$p1]['D'] ?? null;
                $index3 = $neighbors[$p2]['L'] ?? null;
                $index4 = $neighbors[$index3]['L'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') { 
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index2, $index1, $index4, $index3], $p1, $p2))) return $solution;
                }

                /**
                 * CC.
                 * .H.
                 */
                $p2 = $neighbors[$index1]['U'] ?? null;
                $p1 = $neighbors[$p2]['R'] ?? null;
                $index4 = $neighbors[$p2]['R'] ?? null;
                $index3 = $neighbors[$index4]['D'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index4, $index3, $index2, $index1], $p1, $p2))) return $solution;
                }

                /**
                 * .H.
                 * CC.
                 */
                $p2 = $neighbors[$index1]['D'] ?? null;
                $p1 = $neighbors[$p2]['R'] ?? null;
                $index4 = $neighbors[$p2]['R'] ?? null;
                $index3 = $neighbors[$index4]['U'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index4, $index3, $index2, $index1], $p1, $p2))) return $solution;
                }

                continue;
            }
        }
        // Vertical
        else {
            $dirs = ['L', 'R'];

            //$index1 is a forced vertical direction
            if(isset($V[$index1])) {
                /**
                 * ..
                 * CV
                 * C.
                 */
                $p2 = $neighbors[$index2]['L'] ?? null;
                $p1 = $neighbors[$p2]['U'] ?? null;
                $index3 = $neighbors[$index1]['U'] ?? null;
                $index4 = $neighbors[$index3]['L'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index4, $index3, $index1, $index2], $p1, $p2))) return $solution;
                }

                /**
                 * ..
                 * VC
                 * .C
                 */
                $p2 = $neighbors[$index2]['R'] ?? null;
                $p1 = $neighbors[$p2]['U'] ?? null;
                $index3 = $neighbors[$index1]['U'] ?? null;
                $index4 = $neighbors[$index3]['R'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index4, $index3, $index1, $index2], $p1, $p2))) return $solution;
                }

                /**
                 * CC
                 * .V
                 * ..
                 */
                $p1 = $neighbors[$index1]['U'] ?? null;
                $p2 = $neighbors[$p1]['L'] ?? null;
                $index3 = $neighbors[$index2]['L'] ?? null;
                $index4 = $neighbors[$index3]['U'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index1, $index2, $index3, $index4], $p1, $p2))) return $solution;
                }

                /**
                 * CC
                 * V.
                 * ..
                 */
                $p1 = $neighbors[$index1]['U'] ?? null;
                $p2 = $neighbors[$p1]['R'] ?? null;
                $index3 = $neighbors[$index2]['R'] ?? null;
                $index4 = $neighbors[$index3]['U'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index1, $index2, $index3, $index4], $p1, $p2))) return $solution;
                }

                continue;
            }

            //$index2 is a forced vertical direction
            if(isset($V[$index2])) {
                /**
                 * C.
                 * CV
                 * ..
                 */
                $p1 = $neighbors[$index1]['L'] ?? null;
                $p2 = $neighbors[$p1]['D'] ?? null;
                $index4 = $neighbors[$p2]['D'] ?? null;
                $index3 = $neighbors[$index4]['R'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index1, $index2, $index3, $index4], $p1, $p2))) return $solution;
                }

                /**
                 * .C
                 * VC
                 * ..
                 */
                $p1 = $neighbors[$index1]['R'] ?? null;
                $p2 = $neighbors[$p1]['D'] ?? null;
                $index4 = $neighbors[$p2]['D'] ?? null;
                $index3 = $neighbors[$index4]['R'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index1, $index2, $index3, $index4], $p1, $p2))) return $solution;
                }

                /**
                 * ..
                 * V.
                 * CC
                 */
                $p1 = $neighbors[$index2]['D'] ?? null;
                $p2 = $neighbors[$p1]['R'] ?? null;
                $index3 = $neighbors[$p2]['U'] ?? null;
                $index4 = $neighbors[$index3]['U'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index2, $index1, $index4, $index3], $p1, $p2))) return $solution;
                }

                /**
                 * ..
                 * .V
                 * CC
                 */
                $p1 = $neighbors[$index2]['D'] ?? null;
                $p2 = $neighbors[$p1]['L'] ?? null;
                $index3 = $neighbors[$p2]['U'] ?? null;
                $index4 = $neighbors[$index3]['U'] ?? null;

                if($p1 && $p2 && $index3 && $index4 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.' && $grid[$index3] == '.' && $grid[$index4] == '.') {
                    if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index2, $index1, $index4, $index3], $p1, $p2))) return $solution;
                }

                continue;
            }
        }


        foreach($dirs as $dir) {
            $p1 = $neighbors[$index1][$dir] ?? null;
            $p2 = $neighbors[$index2][$dir] ?? null;

            if($p1 && $p2 && ($color = $grid[$p1]) == $grid[$p2] && $color != 'X' && $color != '.') {
                if(($solution = setPositions($groups, $grid, $paths, $groupID, $color, [$index1, $index2], $p1, $p2))) return $solution;
            }
        }
    }

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

// Search all the groups of empty positions that are left
function checkEmptyPositions(string $grid, array $colorsUsed): bool {
    global $size, $neighbors, $w, $V, $H;

    for($index = 0; $index < $size; ++$index) {
        if ($grid[$index] !== '.') continue;
        
        $count = 0;
        $countRestricted = 0;
        $colors = [];
        $visited = [];
        $queue = [$index];

        while($queue) {
            $index2 = array_pop($queue);

            if(isset($visited[$index2])) continue;

            $visited[$index2] = true;
            
            if($grid[$index2] == '.') {
                ++$count;

                if(isset($V[$index2]) || isset($H[$index2])) ++$countRestricted;

                $grid[$index2] = '#';
            } elseif($grid[$index2] != 'X') {
                $colors[$grid[$index2]] = ($colors[$grid[$index2]] ?? 0) + 1;

                continue;
            }
            
            foreach($neighbors[$index2] as $neighbor) $queue[] = $neighbor;
        }

        // When we add empty positions to existing path we can only do it 2 by 2.
        // If we know that no positions can be occupied by a path for another color, having a group of odd size makes it impossible to solve.
        if($count & 1) {
            foreach($colors as $color => $value) {
                if(!isset($colorsUsed[$color]) && $value >= 2) continue 2;
            }

            return false;
        }

        // To assign a position that is forced vertical or horizontal we need 3 empty positions in addition to the one that is forced.
        // If we know that the forced direction position can't be occupied by a path for another color it makes it impossible to solve.
        if($countRestricted * 4 > $count) {
            foreach($colors as $color => $value) {
                if(!isset($colorsUsed[$color]) && $value >= 2) continue 2;
            }

            return false; 
        }
    }

    return true;
}

// We are searching for a path to link all the colors, we don't care if all the positions are used or not
function findPaths(array $colors, string $grid, array $paths = []): bool {
    global $neighbors, $size;

    $color = array_key_last($colors);

    // We have linked all the colors
    if($color === null) {
        $groups = getEmptyPositions($grid);

        if($groups) {
            $paths = assignEmptyPositions($groups, $grid, $paths);

            if(!$paths) return false;
        }

        foreach($paths as $color => $path) {
            foreach(getSections($path, $color) as $section) echo $section . PHP_EOL;
        }

        return true;
    }

    $color = strval($color);
    [$count, $start, $end] = $colors[$color];

    $pq = new SplPriorityQueue();
    $pq->insert([$start, null, 0, 0, 0, [$start => 1]], 0); 

    while (!$pq->isEmpty()) {
        [$index, $dir, $turns, $steps, $occ, $path] = $pq->extract();

        if($grid[$index] == $color) ++$occ;
        
        // We have connected the color
        if($index == $end && $occ == $count) {
            $paths[$color] = array_keys($path);
            $gridWithPath = $grid;

            unset($colors[$color]);
            
            foreach($paths[$color] as $index) $gridWithPath[$index] = $color;

            if(checkEmptyPositions($gridWithPath, array_flip(array_keys($paths)))) {
                if(findPaths($colors, $gridWithPath, $paths)) return true;
            } 

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

// Generate all the moves from each positions
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

findPaths($colors, $grid);

error_log(microtime(1) - $start);
