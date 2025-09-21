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

//Set a given position of the board as being water
function setWater(array &$board, array &$cols, array &$rows, int $x, int $y) {
    if($board[$y][$x] != '.') return;

    $board[$y][$x] = 'x';
    $cols[$x]--;
    $rows[$y]--;
}


function setNeighbor(array &$board, array &$rows, array &$cols, array &$rowMarker, array &$columnMarker, int $x, int $y) {
    global $size;

    switch($board[$y][$x]) {
        case 's':
        case 'S':
            //No ship possible in the 4 diagonals
            foreach([[-1, -1], [-1, 1], [1, -1], [1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu);
            }
            break;
        case 'o':
            //No ship possible all arround
            foreach([[-1, -1], [0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu);
            }
            break;
        case '<': 
            //No ship possible expect on the right
            foreach([[1, -1], [0, -1], [-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu);
            }
            //The position directly on the right has to be part of the boat otherwise it wouldn't have been a '<'
            if($board[$y][$x + 1] == '.') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $x + 1, $y); 
            break;
        case '>':
            //No ship possible expect on the left
            foreach([[-1, -1], [0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu);
            }
            //The position directly on the left has to be part of the boat otherwise it wouldn't have been a '>'
            if($board[$y][$x - 1] == '.') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $x - 1, $y);
            break;
        case '^':
            //No ship possible expect on the bottom
            foreach([[-1, 1], [-1, 0], [-1, -1], [0, -1], [1, -1], [1, 0], [1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu);
            }
            //The position directly on the bottom has to be part of the boat otherwise it wouldn't have been a '^'
            if($board[$y + 1][$x] == '.') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y + 1);
            break;
        case 'v':
            //No ship possible expect on the top
            foreach([[-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1], [1, 0], [1, -1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') setWater($board, $cols, $rows, $xu, $yu);
            }
            //The position directly on the top has to be part of the boat otherwise it wouldn't have been a 'v'
            if($board[$y - 1][$x] == '.') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y - 1);
            break;
    }
}

//Set a given position of the board as being a ship part
function setShip(array &$board, array &$rows, array &$cols, array &$rowMarker, array &$columnMarker, int $x, int $y) {
    if($board[$y][$x] != '.') return;

    $board[$y][$x] = 'S';

    $cols[$x]--;
    $rows[$y]--;
    $columnMarker[$x]--;
    $rowMarker[$y]--;

    setNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y); 
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

//Start by using the ship infos given as input
for($y = 0; $y < $size; ++$y) {
    for($x = 0; $x < $size; ++$x) {
        if($board[$y][$x] != '.') setNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y);
    }
}

while($ships) {
    for($i = 0; $i < $size; ++$i) {
        //Only water in that column
        if(isset($columnMarker[$i]) && $columnMarker[$i] == 0) {
            for($y = 0; $y < $size; ++$y) setWater($board, $cols, $rows, $i, $y, 8);

            //We are done with that column
            unset($cols[$i]);
            unset($columnMarker[$i]);
        }
        //Only water in that row
        if(isset($rowMarker[$i]) && $rowMarker[$i] == 0) {
            for($x = 0; $x < $size; ++$x) setWater($board, $cols, $rows, $x, $i, 9);

            //We are done with that row
            unset($rows[$i]);
            unset($rowMarker[$i]);
        }
        //Only boat parts in that column
        if(isset($columnMarker[$i]) && $cols[$i] == $columnMarker[$i]) {
            for($y = 0; $y < $size; ++$y) setShip($board, $rows, $cols, $rowMarker, $columnMarker, $i, $y);

            //We are done with that column
            unset($cols[$i]);
            unset($columnMarker[$i]);
        }
        //Only boat parts in that row
        if(isset($rowMarker[$i]) && $rows[$i] == $rowMarker[$i]) {
            for($x = 0; $x < $size; ++$x) setShip($board, $rows, $cols, $rowMarker, $columnMarker, $x, $i);

            //We are done with that row
            unset($rows[$i]);
            unset($rowMarker[$i]);
        }
    }

    for($y = 0; $y < $size; ++$y) {
        for($x = 0; $x < $size; ++$x) {
            //We know this isn't the end of a ship, if there can only be one direction, we can extend the ship
            if($board[$y][$x] == 's') {
                //The ship can only be vertical
                if($x == 0 || $x == $size - 1 || $board[$y][$x - 1] == 'x' || $board[$y][$x + 1] == 'x') {
                    if($board[$y - 1][$x] == '.') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y - 1); 
                    if($board[$y + 1][$x] == '.') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y + 1); 
                }
                //The ship can only be horizontal
                if($y == 0 || $y == $size - 1 || $board[$y - 1][$x] == 'x' || $board[$y + 1][$x] == 'x') {
                    if($board[$y][$x - 1] == '.') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $x - 1, $y); 
                    if($board[$y][$x + 1] == '.') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $x + 1, $y); 
                }
            }
        }
    }

    for($y = 0; $y < $size; ++$y) {
        preg_match_all("/[\<\>osS]+/", $board[$y], $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [$match, $offset]) {
            $len = strlen($match);

            //This is already the biggest ship size that's left
            if($len == array_key_last($ships)) {
                //The left has to be water
                if($offset > 0 && $board[$y][$offset - 1] == '.') setWater($board, $cols, $rows, $offset - 1, $y);
                //The right has to be water
                if($offset + $len < $size && $board[$y][$offset + $len] == '.') setWater($board, $cols, $rows, $offset + $len, $y);
            }

            if(($offset == 0 || $board[$y][$offset - 1] == 'x') && ($offset + $len == $size || $board[$y][$offset + $len] == 'x')) {
                //We have found a full ship
                if($len > 1 || (($y == 0 || $board[$y - 1][$offset] == 'x') && ($y == $size - 1 || $board[$y + 1][$offset] == 'x'))) {
                    if($ships[$len] > 1) --$ships[$len];
                    else unset($ships[$len]);

                    for($i = 0; $i < $len; ++$i) $board[$y][$offset + $i] = '#'; //We use '#' to represent the ships fully discovered
                }
            } //We don't need the current ship, we need to increase the size
            elseif(!isset($ships[$len])) {
                //Increase size to the left - impossible to the right
                if($offset + $len == $size || $board[$y][$offset + $len] == 'x') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $offset - 1, $y);
                
                //Increase size to the right - impossible to the left
                if($offset == 0 || $board[$y][$offset - 1] == 'x') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $offset + $len, $y);
            } 
        }
    }

    $rotatedBoard = rotateBoard($board);

    for($y = 0; $y < $size; ++$y) {
        preg_match_all("/[\^vosS]+/", $rotatedBoard[$y], $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [$match, $offset]) {
            $len = strlen($match);

            //This is already the biggest ship that's left
            if($len == array_key_last($ships)) {
                //The top has to be water
                if($offset > 0 && $board[$offset - 1][$y] == '.') setWater($board, $cols, $rows, $y, $offset - 1);
                //The bottom has to be water
                if($offset + $len < $size && $board[$offset + 1][$y] == '.') setWater($board, $cols, $rows, $y, $offset + $len);
            }

            if(($offset == 0 || $board[$offset - 1][$y] == 'x') && ($offset + $len == $size || $board[$offset + $len][$y] == 'x')) {
                //We have found a full ship
                if($len > 1 || (($y == 0 || $rotatedBoard[$y - 1][$offset] == 'x') && ($y == $size - 1 || $rotatedBoard[$y + 1][$offset] == 'x'))) {
                    if($ships[$len] > 1) --$ships[$len];
                    else unset($ships[$len]);

                    for($i = 0; $i < $len; ++$i) $board[$offset + $i][$y] = '#'; //We use '#' to represent the ships fully discovered
                }
            } //We don't need the current ship, we need to increase the size
            elseif(!isset($ships[$len])) {
                //Increase size to the top - impossible to the bottom
                if($offset + $len == $size || $rotatedBoard[$y][$offset + $len] == 'x') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset - 1);
                
               //Increase size to the bottom - impossible to the top
                if($offset == 0 || $rotatedBoard[$y][$offset - 1] == 'x') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset + $len);
            } 
        }
    }

    $needeSizes = $ships;
    unset($needeSizes[1]); //Don't bother with ships of size 1

    $posiblePositions = [];
    $rotatedBoard = rotateBoard($board);

    for($y = 0; $y < $size; ++$y) {
        //We still have some positions to find in that row
        if(isset($rowMarker[$y])) {
            preg_match_all("/[\.\<\>osS]+/", $board[$y], $matches, PREG_OFFSET_CAPTURE);

            foreach($matches[0] as [$match, $offset]) {
                $len = strlen($match);

                foreach($needeSizes as $shipSize => $count) {
                    if($shipSize > $len) break;

                    //We start with all the positions in the match
                    $commonPositions = array_flip(range($offset, $offset + $len - 1));
                    $foundPosibility = false;

                    for($i = 0; $i <= $len - $shipSize; ++$i) {
                        //Ships can't touch each others
                        if($i > 0 && $match[$i - 1] != '.') continue;
                        if($i + $shipSize < $len && $match[$i + $shipSize] != '.') continue;

                        $missing = substr_count(substr($match, $i, $shipSize), '.');

                        //We can't reach ship size because of the row hint
                        if($missing > $rowMarker[$y]) continue;

                        $foundPosibility = true;
                        //All the positions used by all the posibilities have to be ship parts
                        $commonPositions = array_intersect_key($commonPositions, array_flip(range($offset + $i, $offset + $i + $shipSize - 1)));
                    }

                    if($foundPosibility) {
                        $posiblePositions[$shipSize][] = ['H', $y, $commonPositions];

                        //Too many possibilities, we can be certain
                        if(count($posiblePositions[$shipSize]) > $ships[$shipSize]) {
                            unset($posiblePositions[$shipSize]);
                            unset($needeSizes[$shipSize]);
                        }
                    }
                }
            }
        }

        preg_match_all("/[\.\^vosS]+/", $rotatedBoard[$y], $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [$match, $offset]) {
            //We still have some positions to find in that col
            if(isset($columnMarker[$y])) {
                $len = strlen($match);

                foreach($needeSizes as $shipSize => $count) {
                    if($shipSize > $len) break;

                    //We start with all the positions in the match
                    $commonPositions = array_flip(range($offset, $offset + $len - 1));
                    $foundPosibility = false;

                    for($i = 0; $i <= $len - $shipSize; ++$i) {
                        //Ships can't touch each others
                        if($i > 0 && $match[$i - 1] != '.') continue;
                        if($i + $shipSize < $len && $match[$i + $shipSize] != '.') continue;

                        $missing = substr_count(substr($match, $i, $shipSize), '.');

                        //We can't reach ship size because of the col hint
                        if($missing > $columnMarker[$y]) continue;

                        $foundPosibility = true;
                        //All the positions used by all the posibilities have to be ship parts
                        $commonPositions = array_intersect_key($commonPositions, array_flip(range($offset + $i, $offset + $i + $shipSize - 1)));
                    }

                    if($foundPosibility) {
                        $posiblePositions[$shipSize][] = ['V', $y, $commonPositions];

                        //Too many possibilities, we can be certain
                        if(count($posiblePositions[$shipSize]) > $ships[$shipSize]) {
                            unset($posiblePositions[$shipSize]);
                            unset($needeSizes[$shipSize]);
                        }
                    }
                }
            }
        }
    }
    
    //We have some ships that have positions that are certain
    if($posiblePositions) {
        foreach($posiblePositions as $shipSize => $list) {
            foreach($list as [$d, $v1, $positions]) {
                foreach($positions as $v2 => $filler) {
                    if($d == 'H') setShip($board, $rows, $cols, $rowMarker, $columnMarker, $v2, $v1);
                    else setShip($board, $rows, $cols, $rowMarker, $columnMarker, $v1, $v2);
                }

                //We have the full ship
                if(count($positions) == $shipSize) {
                    //Left/Top has to be water
                    $first = array_key_first($positions);

                    if($first > 0) {
                        if($d == 'H' && $board[$v1][$first - 1] == '.') setWater($board, $cols, $rows, $first - 1, $v1);
                        elseif($d == 'V' && $board[$first - 1][$v1] == '.') setWater($board, $cols, $rows, $v1, $first - 1);
                    } 

                    //Right/Bottom has to be water
                    $last = array_key_last($positions);

                    if($last < $size - 1) {
                        if($d == 'H' && $board[$v1][$first + 1] == '.') setWater($board, $cols, $rows, $first + 1, $v1);
                        elseif($d == 'V' && $board[$first + 1][$v1] == '.') setWater($board, $cols, $rows, $v1, $first + 1);
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
