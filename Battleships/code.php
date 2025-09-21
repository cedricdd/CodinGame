<?php

function rotateBoard(array $board): array {
    global $size;

    $rotated = [];
    
    for($x = 0; $x < $size; ++$x) {
        $line = "";
    
        for($y = 0; $y < $size; ++$y) $line .= $board[$y][$x];
        
        $rotated[] = $line;
    }
    
    return $rotated;
}

function setWater(array &$board, array &$cols, array &$rows, int $x, int $y, int $test = -1) {
    if($board[$y][$x] != '.') return;

    // error_log("setting water at $x $y - $test");

    $board[$y][$x] = 'x';
    $cols[$x]--;
    $rows[$y]--;
}

function checkNeighbor(array &$board, array &$rows, array &$cols, array &$rowMarker, array &$columnMarker, int $x, int $y) {
    global $size;

    switch($board[$y][$x]) {
        case 's':
        case 'S':
            foreach([[-1, -1], [-1, 1], [1, -1], [1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu, 1);
            }
            break;
        case 'o':
            foreach([[-1, -1], [0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu, 2);
            }
            break;
        case '<': 
            foreach([[1, -1], [0, -1], [-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu, 3);
            }
            if($board[$y][$x + 1] == '.') {
                setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x + 1, $y); 
            }
            break;
        case '>':
            foreach([[-1, -1], [0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu, 4);
            }
            if($board[$y][$x - 1] == '.') {
                setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x - 1, $y);
            }
            break;
        case '^':
            foreach([[-1, 1], [-1, 0], [-1, -1], [0, -1], [1, -1], [1, 0], [1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu, 5);
            }
            if($board[$y + 1][$x] == '.') {
                setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y + 1);
            }
            break;
        case 'v':
            foreach([[-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1], [1, 0], [1, -1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu, 6);
            }
            if($board[$y - 1][$x] == '.') {
                setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y - 1);
            }
            break;
    }
}

function setPosition(array &$board, array &$rows, array &$cols, array &$rowMarker, array &$columnMarker, int $x, int $y) {
    if($board[$y][$x] != '.') return;

    error_log("setting $x $y as ship part");

    $board[$y][$x] = 'S';

    $cols[$x]--;
    $rows[$y]--;
    $columnMarker[$x]--;
    $rowMarker[$y]--;

    checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y); 
}

fscanf(STDIN, "%d", $size);

$start = microtime(1);
$columnMarker = array_map('intval', explode(" ", trim(fgets(STDIN))));
$rowMarker = array_map('intval', explode(" ", trim(fgets(STDIN))));

fscanf(STDIN, "%d", $shipsCount);

$ships = [];

foreach(explode(" ", trim(fgets(STDIN))) as $shipSize) {
    if(!isset($ships[$shipSize])) $ships[$shipSize] = 1;
    else $ships[$shipSize]++;
}

ksort($ships);

error_log(var_export($ships, 1));

$cols = array_fill(0, $size, 0);
$rows = array_fill(0, $size, 0);

for ($y = 0; $y < $size; ++$y) {
    $board[$y] = str_repeat(' ', $size);

    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if($c == ".") {
            $cols[$x]++;
            $rows[$y]++;
        } elseif($c != 'x') {
            $columnMarker[$x]--;
            $rowMarker[$y]--;
        }

        $board[$y][$x] = $c;
    }
}

for($y = 0; $y < $size; ++$y) {
    for($x = 0; $x < $size; ++$x) {
        if($board[$y][$x] != '.') checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y);
    }
}

while($ships) {
    // error_log(var_export("columnMarker: " . implode('-', $columnMarker), 1));
    // error_log(var_export("rowMarker: " . implode('-', $rowMarker), 1));
    // error_log(var_export("cols: " . implode('-', $cols), 1));
    // error_log(var_export("rows: " . implode('-', $rows), 1));

    for($i = 0; $i < $size; ++$i) {
        //Only water in that column
        if(isset($columnMarker[$i]) && $columnMarker[$i] == 0) {
            for($y = 0; $y < $size; ++$y) {
                if($board[$y][$i] == '.') setWater($board, $cols, $rows, $i, $y, 8);
            }

            unset($cols[$i]);
            unset($columnMarker[$i]);
        }
        //Only water in that row
        if(isset($rowMarker[$i]) && $rowMarker[$i] == 0) {
            for($x = 0; $x < $size; ++$x) {
                if($board[$i][$x] == '.') setWater($board, $cols, $rows, $x, $i, 9);
            }

            unset($rows[$i]);
            unset($rowMarker[$i]);
        }
        //Only boat parts in that column
        if(isset($columnMarker[$i]) && $cols[$i] == $columnMarker[$i]) {
            for($y = 0; $y < $size; ++$y) {
                if($board[$y][$i] == '.') {
                    $rowMarker[$y]--;
                    $rows[$y]--;
                    $board[$y][$i] = 'S';

                    checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $i, $y);
                }
            }

            unset($cols[$i]);
            unset($columnMarker[$i]);
        }
        //Only boat parts in that row
        if(isset($rowMarker[$i]) && $rows[$i] == $rowMarker[$i]) {
            for($x = 0; $x < $size; ++$x) {
                if($board[$i][$x] == '.') {
                    $columnMarker[$x]--;
                    $cols[$x]--;
                    $board[$i][$x] = 'S';

                    checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $x, $i);
                }
            }

            unset($rows[$i]);
            unset($rowMarker[$i]);
        }
    }

    for($y = 0; $y < $size; ++$y) {
        for($x = 0; $x < $size; ++$x) {
            if($board[$y][$x] == 's') {
                if($x == 0 || $x == $size - 1 || $board[$y][$x - 1] == 'x' || $board[$y][$x + 1] == 'x') {
                    if($board[$y - 1][$x] == '.') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y - 1); 
                    if($board[$y + 1][$x] == '.') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y + 1); 
                }
                if($y == 0 || $y == $size - 1 || $board[$y - 1][$x] == 'x' || $board[$y + 1][$x] == 'x') {
                    if($board[$y][$x - 1] == '.') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x - 1, $y); 
                    if($board[$y][$x + 1] == '.') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x + 1, $y); 
                }
            }
        }
    }

    // error_log(var_export($board, 1));

    for($y = 0; $y < $size; ++$y) {
        preg_match_all("/[\<\>osS]+/", $board[$y], $matches, PREG_OFFSET_CAPTURE);

        // error_log(var_export($matches, 1));

        foreach($matches[0] as [$match, $offset]) {
            $len = strlen($match);

            for($i = 0; $i < $len; ++$i) {
                if($y > 0 && $board[$y - 1][$offset + $i] != 'x' && $board[$y - 1][$offset + $i] != '.') continue 2;
                if($y < $size - 1 && $board[$y + 1][$offset + $i] != 'x' && $board[$y + 1][$offset + $i] != '.') continue 2;
            }

            // error_log("1) $match ($len) at line $y offset $offset is good");

            //This is already the biggest ship that's left
            if($len == array_key_last($ships)) {
                $board[$y][$offset] = '<';
                $board[$y][$offset + $len - 1] = '>';

                checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset);
                checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset + $len - 1);
            }

            if(($offset == 0 || $board[$y][$offset - 1] == 'x') && ($offset + $len == $size || $board[$y][$offset + $len] == 'x')) {
                //We have found a full ship
                if($len > 1 || (($y == 0 || $board[$y - 1][$offset] == 'x') && ($y == $size - 1 || $board[$y + 1][$offset] == 'x'))) {
                    // error_log("at Line $y - offset $offset we have ship of len $len");

                    if($ships[$len] > 1) --$ships[$len];
                    else unset($ships[$len]);

                    for($i = 0; $i < $len; ++$i) $board[$y][$offset + $i] = '#';
                }
            } elseif(!isset($ships[$len])) {
                // error_log("at Line $y - offset $offset we have ship of len $len that can't be a full ship");

                //We increase size to the left
                if($offset + $len == $size || $board[$y][$offset + $len] == 'x') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $offset - 1, $y);
                
                //We increase size to the right
                if($offset == 0 || $board[$y][$offset - 1] == 'x') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $offset + $len, $y);
            } 
        }
    }

    $rotatedBoard = rotateBoard($board);

    // error_log(var_export($rotatedBoard, 1));

    for($y = 0; $y < $size; ++$y) {
        preg_match_all("/[\^vosS]+/", $rotatedBoard[$y], $matches, PREG_OFFSET_CAPTURE);

        // error_log(var_export($matches, 1));

        foreach($matches[0] as [$match, $offset]) {
            $len = strlen($match);

            for($i = 0; $i < $len; ++$i) {
                if($y > 0 && $rotatedBoard[$y - 1][$offset + $i] != 'x' && $rotatedBoard[$y - 1][$offset + $i] != '.') continue 2;
                if($y < $size - 1 && $rotatedBoard[$y + 1][$offset + $i] != 'x' && $rotatedBoard[$y + 1][$offset + $i] != '.') continue 2;
            }

            //This is already the biggest ship that's left
            if($len == array_key_last($ships)) {
                if($offset > 1 && $board[$offset - 1][$y] == '.') setWater($board, $cols, $rows, $y, $offset - 1, 101);
                if($offset < $size - 1 && $board[$offset + 1][$y] == '.') setWater($board, $cols, $rows, $y, $offset + 1, 102);

                error_log("setting $y $offset as ^ and $y " . ($offset + $len - 1) . " as v");
                error_log(var_export($board, 1));
            }

            if(($offset == 0 || $board[$offset - 1][$y] == 'x') && ($offset + $len == $size || $board[$offset + $len][$y] == 'x')) {
                //We have found a full ship
                if($len > 1 || (($y == 0 || $rotatedBoard[$y - 1][$offset] == 'x') && ($y == $size - 1 || $rotatedBoard[$y + 1][$offset] == 'x'))) {
                    // error_log("at Line $y - offset $offset we have ship of len $len");
                    
                    if($ships[$len] > 1) --$ships[$len];
                    else unset($ships[$len]);

                    for($i = 0; $i < $len; ++$i) $board[$offset + $i][$y] = '#';
                }
            } elseif(!isset($ships[$len])) {
                // error_log("at Col $y - offset $offset we have ship of len $len that can't be a full ship");

                //We increase size to the left
                if($offset + $len == $size || $rotatedBoard[$y][$offset + $len] == 'x') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset - 1);
                
                //We increase size to the right
                if($offset == 0 || $rotatedBoard[$y][$offset - 1] == 'x') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset + $len);
            } 
        }
    }

    // error_log(var_export($ships, 1));
    error_log(var_export($board, 1));

    $testSizes = $ships;
    unset($testSizes[1]);
    $testPositions = [];
    $rotatedBoard = rotateBoard($board);

    for($y = 0; $y < $size; ++$y) {
        if(isset($rowMarker[$y])) {
            // error_log("Checking $y with " . $rowMarker[$y]);
            preg_match_all("/[\.\<\>osS]+/", $board[$y], $matches, PREG_OFFSET_CAPTURE);

            foreach($matches[0] as [$match, $offset]) {
                $len = strlen($match);

                foreach($testSizes as $shipSize => $count) {
                    if($shipSize > $len) break;

                    $commonPositions = array_flip(range($offset, $offset + $len - 1));
                    $foundPosibility = false;

                    // error_log("$match - $offset - $shipSize");
                    // error_log(var_export($commonPositions, 1));
                    // exit();
                    
                    for($i = 0; $i <= $len - $shipSize; ++$i) {
                        // error_log("Testing i $i");

                        if($i > 0 && $match[$i - 1] != '.') continue;
                        if($i + $shipSize < $len && $match[$i + $shipSize] != '.') continue;

                        // error_log("left & right is good");

                        $block = substr($match, $i, $shipSize);
                        $missing = substr_count($block, '.');

                        if($missing > $rowMarker[$y]) continue;

                        // error_log("missing $missing <= left {$rowMarker[$y]}");

                        $foundPosibility = true;

                        $commonPositions = array_intersect_key($commonPositions, array_flip(range($offset + $i, $offset + $i + $shipSize - 1)));

                        // error_log("we found a solution for size $shipSize, starting at " . ($offset + $i));
                        // error_log(var_export($commonPositions, 1));
                        // exit();
                    }

                    if($foundPosibility) {
                        $testPositions[$shipSize][] = ['H', $y, $commonPositions];

                        if(count($testPositions[$shipSize]) > $ships[$shipSize]) {
                            // error_log("we have too many possibilities for size $shipSize");
                            unset($testPositions[$shipSize]);
                            unset($testSizes[$shipSize]);
                        }
                    }
                }
            }
        }

        preg_match_all("/[\.\^vosS]+/", $rotatedBoard[$y], $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [$match, $offset]) {
            if(isset($columnMarker[$y])) {
                $len = strlen($match);

                foreach($testSizes as $shipSize => $count) {
                    if($shipSize > $len) break;

                    $commonPositions = array_flip(range($offset, $offset + $len - 1));
                    $foundPosibility = false;

                    for($i = 0; $i <= $len - $shipSize; ++$i) {
                        // error_log("Testing i $i");

                        if($i > 0 && $match[$i - 1] != '.') continue;
                        if($i + $shipSize < $len && $match[$i + $shipSize] != '.') continue;

                        // error_log("left & right is good");

                        $block = substr($match, $i, $shipSize);
                        $missing = substr_count($block, '.');

                        if($missing > $columnMarker[$y]) continue;

                        // error_log("missing $missing <= left {$rowMarker[$y]}");

                        $foundPosibility = true;

                        $commonPositions = array_intersect_key($commonPositions, array_flip(range($offset + $i, $offset + $i + $shipSize - 1)));

                        // error_log("we found a solution for size $shipSize, starting at " . ($offset + $i));
                        // error_log(var_export($commonPositions, 1));
                        // exit();
                    }

                    if($foundPosibility) {
                        $testPositions[$shipSize][] = ['V', $y, $commonPositions];

                        if(count($testPositions[$shipSize]) > $ships[$shipSize]) {
                            // error_log("we have too many possibilities for size $shipSize");
                            unset($testPositions[$shipSize]);
                            unset($testSizes[$shipSize]);
                        }
                    }
                }
            }
        }
    }
    
    if($testPositions) {
        foreach($testPositions as $shipSize => $list) {
            foreach($list as [$d, $v1, $positions]) {
                foreach($positions as $v2 => $filler) {
                    if($d == 'H') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $v2, $v1);
                    else setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $v1, $v2);
                }

                //We have the full ship
                if(count($positions) == $shipSize) {
                    $first = array_key_first($positions);

                    if($first > 0) {
                        if($d == 'H' && $board[$v1][$first - 1] == '.') setWater($board, $cols, $rows, $first - 1, $v1, 10);
                        elseif($d == 'V' && $board[$first - 1][$v1] == '.') setWater($board, $cols, $rows, $v1, $first - 1, 11);
                    } 

                    $last = array_key_last($positions);

                    if($first > 0) {
                        if($d == 'H' && $board[$v1][$first + 1] == '.') setWater($board, $cols, $rows, $first + 1, $v1, 12);
                        elseif($d == 'V' && $board[$first + 1][$v1] == '.') setWater($board, $cols, $rows, $v1, $first + 1, 13);
                    } 
                } 
            }
        }
    }
}

echo implode(PHP_EOL, array_map(function($line) {
    return strtr($line, "#.", "ox");
}, $board)) . PHP_EOL;

error_log(microtime(1) - $start);
