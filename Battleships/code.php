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

function checkNeighbor(array &$board, array &$rows, array &$cols, array &$rowMarker, array &$columnMarker, int $x, int $y) {
    global $size;

    switch($board[$y][$x]) {
        case 's':
        case 'S':
            foreach([[-1, -1], [-1, 1], [1, -1], [1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') {
                    $board[$yu][$xu] = 'x';
                    $cols[$xu]--;
                    $rows[$yu]--;
                }
            }
            break;
        case 'o':
            foreach([[-1, -1], [0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') {
                    $board[$yu][$xu] = 'x';
                    $cols[$xu]--;
                    $rows[$yu]--;
                }
            }
            break;
        case '<': 
            foreach([[1, -1], [0, -1], [-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') {
                    $board[$yu][$xu] = 'x';
                    $cols[$xu]--;
                    $rows[$yu]--;
                }
            }
            if($board[$y][$x + 1] == '.') {
                setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x + 1, $y); 
            }
            break;
        case '>':
            foreach([[-1, -1], [0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') {
                    $board[$yu][$xu] = 'x';
                    $cols[$xu]--;
                    $rows[$yu]--;
                }
            }
            if($board[$y][$x - 1] == '.') {
                setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x - 1, $y);
            }
            break;
        case '^':
            foreach([[-1, 1], [-1, 0], [-1, -1], [0, -1], [1, -1], [1, 0], [1, 1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') {
                    $board[$yu][$xu] = 'x';
                    $cols[$xu]--;
                    $rows[$yu]--;
                }
            }
            if($board[$y + 1][$x] == '.') {
                setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y + 1);
            }
            break;
        case 'v':
            foreach([[-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1], [1, 0], [1, -1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $size && $yu >= 0 && $yu < $size && $board[$yu][$xu] == '.') {
                    $board[$yu][$xu] = 'x';
                    $cols[$xu]--;
                    $rows[$yu]--;
                }
            }
            if($board[$y - 1][$x] == '.') {
                setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y - 1);
            }
            break;
    }
}

function setPosition(array &$board, array &$rows, array &$cols, array &$rowMarker, array &$columnMarker, int $x, int $y) {
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

error_log(var_export($board, 1));

for($y = 0; $y < $size; ++$y) {
    for($x = 0; $x < $size; ++$x) {
        if($board[$y][$x] != '.') checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y);
    }
}

while($ships) {
    error_log(var_export("columnMarker: " . implode('-', $columnMarker), 1));
    error_log(var_export("rowMarker: " . implode('-', $rowMarker), 1));
    error_log(var_export("cols: " . implode('-', $cols), 1));
    error_log(var_export("rows: " . implode('-', $rows), 1));

    for($i = 0; $i < $size; ++$i) {
        //Only water in that column
        if(isset($columnMarker[$i]) && $columnMarker[$i] == 0) {
            for($y = 0; $y < $size; ++$y) {
                if($board[$y][$i] == '.') {
                    $board[$y][$i] = 'x';
                    $rows[$y]--;
                }
            }

            unset($cols[$i]);
            unset($columnMarker[$i]);
        }
        //Only water in that row
        if(isset($rowMarker[$i]) && $rowMarker[$i] == 0) {
            for($x = 0; $x < $size; ++$x) {
                if($board[$i][$x] == '.') {
                    $board[$i][$x] = 'x';
                    $cols[$x]--;
                }
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
        //Only boat parts in thta row
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
                if($x > 0 && $x < $size - 1 && $board[$y][$x - 1] == 'x' && $board[$y][$x + 1] == 'x') {
                    if($board[$y - 1][$x] == '.') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y - 1); 
                    if($board[$y + 1][$x] == '.') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x, $y + 1); 
                }
                if($y > 0 && $y < $size - 1 && $board[$y - 1][$x] == 'x' && $board[$y + 1][$x] == 'x') {
                    if($board[$y][$x - 1] == '.') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x - 1, $y); 
                    if($board[$y][$x + 1] == '.') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $x + 1, $y); 
                }
            }
        }
    }

    error_log(var_export($board, 1));

    for($y = 0; $y < $size; ++$y) {
        preg_match_all("/[\<\>osS]+/", $board[$y], $matches, PREG_OFFSET_CAPTURE);

        // error_log(var_export($matches, 1));

        foreach($matches[0] as [$match, $offset]) {
            $len = strlen($match);

            for($i = 0; $i < $len; ++$i) {
                if($y > 0 && $board[$y - 1][$offset + $i] != 'x' && $board[$y - 1][$offset + $i] != '.') continue 2;
                if($y < $size - 1 && $board[$y + 1][$offset + $i] != 'x' && $board[$y + 1][$offset + $i] != '.') continue 2;
            }

            error_log("1) $match ($len) at line $y offset $offset is good");

            if(($offset == 0 || $board[$y][$offset - 1] == 'x') && ($offset + $len == $size || $board[$y][$offset + $len] == 'x')) {
                //We have found a full ship
                if($len > 1 || (($y == 0 || $board[$y - 1][$offset] == 'x') && ($y == $size - 1 || $board[$y + 1][$offset] == 'x'))) {
                    error_log("at Line $y - offset $offset we have ship of len $len");

                    if($ships[$len] > 1) --$ships[$len];
                    else unset($ships[$len]);

                    for($i = 0; $i < $len; ++$i) $board[$y][$offset + $i] = '#';
                }
            } elseif(!isset($ships[$len])) {
                error_log("at Line $y - offset $offset we have ship of len $len that can't be a full ship");

                //We increase size to the left
                if($offset + $len == $size || $board[$y][$offset + $len] == 'x') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $offset - 1, $y);
                
                //We increase size to the right
                if($offset == 0 || $board[$y][$offset - 1] == 'x') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $offset + $len, $y);
            } elseif($len > 1 && !isset($ships[$len + 1])) {
                $board[$y][$offset] = '<';
                $board[$y][$offset + $len - 1] = '>';

                checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset);
                checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset + $len - 1);
            }
        }
    }

    $rotatedBoard = rotateBoard($board);

    error_log(var_export($rotatedBoard, 1));

    for($y = 0; $y < $size; ++$y) {
        preg_match_all("/[\^vosS]+/", $rotatedBoard[$y], $matches, PREG_OFFSET_CAPTURE);

        // error_log(var_export($matches, 1));

        foreach($matches[0] as [$match, $offset]) {
            $len = strlen($match);

            for($i = 0; $i < $len; ++$i) {
                if($y > 0 && $rotatedBoard[$y - 1][$offset + $i] != 'x' && $rotatedBoard[$y - 1][$offset + $i] != '.') continue 2;
                if($y < $size - 1 && $rotatedBoard[$y + 1][$offset + $i] != 'x' && $rotatedBoard[$y + 1][$offset + $i] != '.') continue 2;
            }

            error_log("2) $match ($len) at line $y offset $offset is good");

            if(($offset == 0 || $rotatedBoard[$y][$offset - 1] == 'x') && ($offset + $len == $size || $rotatedBoard[$y][$offset + $len] == 'x')) {
                //We have found a full ship
                if($len > 1 || (($y == 0 || $rotatedBoard[$y - 1][$offset] == 'x') && ($y == $size - 1 || $rotatedBoard[$y + 1][$offset] == 'x'))) {
                    error_log("at Line $y - offset $offset we have ship of len $len");
                    
                    if($ships[$len] > 1) --$ships[$len];
                    else unset($ships[$len]);

                    for($i = 0; $i < $len; ++$i) $board[$offset + $i][$y] = '#';
                }
            } elseif(!isset($ships[$len])) {
                error_log("at Col $y - offset $offset we have ship of len $len that can't be a full ship");

                //We increase size to the left
                if($offset + $len == $size || $rotatedBoard[$y][$offset + $len] == 'x') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset - 1);
                
                //We increase size to the right
                if($offset == 0 || $rotatedBoard[$y][$offset - 1] == 'x') setPosition($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset + $len);
            } elseif($len > 1 && !isset($ships[$len + 1])) {
                $board[$offset][$y] = '^';
                $board[$offset + $len - 1][$y] = 'v';

                checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset);
                checkNeighbor($board, $rows, $cols, $rowMarker, $columnMarker, $y, $offset + $len - 1);
            }
        }
    }

    error_log(var_export($ships, 1));
}

echo implode(PHP_EOL, array_map(function($line) {
    return strtr($line, "#.", "ox");
}, $board)) . PHP_EOL;

error_log(microtime(1) - $start);
