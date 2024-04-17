<?php

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; ++$i) {
    fscanf(STDIN, "%d %d %d", $height[], $start[], $end[]);
}

$minX = min($start);
$maxX = max($end);
$sizeX = $maxX - $minX;
$sizeY = max($height);
$city = array_fill(0, $sizeY, array_fill(0, $sizeX, '+'));

//Add all the buildings to the city
for($i = 0; $i < $n; ++$i) {
    for($y = 1; $y <= $height[$i]; ++$y) {
        for($x = $start[$i] - $minX; $x < $end[$i] - $minX; ++$x) {
            $city[$sizeY - $y][$x] = "*";
        }
    }
}

$output = [];
$d = 'U';
$x = 0;
$y = $sizeY - 1;
$index = 0;

//Draw the skylines
while($x < $sizeX && $y < $sizeY) {
    //We are moving up
    if($d == 'U') {
        $output[$y + 1][$index] = '|';

        if(($city[$y - 1][$x] ?? '+') == '*') { //We continue up
            --$y;
        } elseif(($city[$y - 1][$x + 1] ?? '+') == '*') { //We continue up after moving left
            $output[$y][++$index] = '_';
            ++$index;
            
            --$y;
            ++$x;
        } elseif(($city[$y][$x + 1] ?? '+') == '*') { //We swtich right
            $output[$y][++$index] = '_';
            ++$index;

            ++$x;
            $d = 'R';
        } else { //We switch down
            $output[$y][++$index] = '_';
            ++$index;

            $d = 'D';
        }
    }
    //We are moving right
    elseif($d == 'R') {
        $output[$y][$index++] = '_';

        if(($city[$y - 1][$x + 1] ?? '+') == '*') { //We switch up
            --$y;
            ++$x;

            $d = 'U';
        } elseif(($city[$y][$x + 1] ?? '+') == '*') { //We continue right
            ++$x;
        } elseif(($city[$y + 1][$x + 1] ?? '+') == '*') { //We continue right after moving down
            $output[$y + 1][$index++] = '|';
            
            ++$y;
            ++$x;
        } else { //We switch down
            $output[$y + 1][$index] = '|';

            $d = 'D';
        }
    }
    //We are moving down
    else {
        $output[$y + 1][$index] = '|';

        //We reached the floor, switch right
        if($y == $sizeY - 1) {
            ++$index;

            //Add the floor until the next building starts
            while(($city[$y][++$x] ?? '*') == '+') {
                $output[$y + 1][$index++] = $last = '_';
            }

            $d = 'U';
        } else {
            if(($city[$y + 1][$x + 1] ?? '+') == '*') { //We switch right
                ++$index;

                ++$y;
                ++$x;
                $d = 'R';
            }
            //We continue down
            else ++$y;
        }
    }
}

//Display the skyline
for($y = 0; $y <= $sizeY; ++$y) {
    $line = str_repeat(" ", $index);

    foreach(($output[$y] ?? []) as $x => $c) $line[$x] = $c;

    echo rtrim($line) . PHP_EOL;
}
