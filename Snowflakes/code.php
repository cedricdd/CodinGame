<?php

//Function to rotate 90°
function rotateLeft(string $snowflake): string {
    $rotated = [];

    $snowflake = explode("-", $snowflake);
    $h = count($snowflake);
    $w = strlen($snowflake[0]);
    
    for($x = $w - 1; $x >= 0; --$x) {
        $line = "";
    
        for($y = 0; $y < $h; ++$y) $line .= $snowflake[$y][$x];
        
        $rotated[] = $line;
    }

    return implode("-", $rotated);
}

//Return the snowflake mirrored vertically
function mirror(string $snowflake): string {
    $snowflake = explode("-", $snowflake);

    foreach($snowflake as $i => $line) {
        $snowflake[$i] = strrev($line);
    }

    return implode("-", $snowflake);
}

function generateHashes(string $snowflake, int $w, int $h) {
    global $snowflakes;

    for($j = 0; $j < 2; ++$j) {
        for($i = 0; $i < 4; ++$i) {
            $snowflake = rotateLeft($snowflake);
            $snowflakes[$snowflake] = ($j+1)*($i+1);
        }

        $snowflake = mirror($snowflake);
    }
}

fscanf(STDIN, "%d %d", $h, $w);
for ($i = 0; $i < $h; $i++) {
    $grid[] = trim(fgets(STDIN));
}

$snowflakes = [];
$total = 0;
$unique = 0;

for($y2 = 0; $y2 < $h; ++$y2) {
    for($x2 = 0; $x2 < $w; ++$x2) {
        //A snowflake starts here
        if($grid[$y2][$x2] == '*') {
            ++$total;

            $minX = $minY = INF;
            $maxX = $maxY = -INF;

            $queue = [[$x2, $y2]];
            $positions = [];

            //Find all the positions of the snowflake
            while($queue) {
                [$x, $y] = array_pop($queue);

                $grid[$y][$x] = '.';
                $positions[] = [$x, $y];

                if($x > $maxX) $maxX = $x;
                if($x < $minX) $minX = $x;
                if($y > $maxY) $maxY = $y;
                if($y < $minY) $minY = $y;

                foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                    $xu = $x + $xm;
                    $yu = $y + $ym;

                    if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h && $grid[$yu][$xu] == '*') $queue[] = [$xu, $yu];
                }
            }

            $w2 = $maxX - $minX + 1;
            $h2 = $maxY - $minY + 1;

            $snowflake = array_fill(0, $h2, str_repeat(".", $w2));

            foreach($positions as [$x, $y]) {
                $snowflake[$y - $minY][$x - $minX] = '*';
            }

            $snowflake = implode("-", $snowflake);

            //It's an unique snowflake
            if(!isset($snowflakes[$snowflake])) {
                generateHashes($snowflake, $w2, $h2);
                
                ++$unique;
            } else {
                error_log("Already exist: " . $snowflakes[$snowflake]);
            }
        }
    }
}

echo $total . PHP_EOL;
echo $unique . PHP_EOL;
