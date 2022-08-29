<?php

fscanf(STDIN, "%d %d", $width, $height);
for ($i = 0; $i < $height; $i++) {
    // $row: A single row of the map consisting of passable terrain ('.') and walls ('#')
    $grid[] = trim(fgets(STDIN));
}

$start = microtime(1);

error_log(var_export($grid, true)); 

$jumpPoints = [];
$distances = [];

//Find jump points
for($y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x) {
        if($grid[$y][$x] == "#") continue;

        if($y > 0 && $x > 0 && $grid[$y - 1][$x - 1] == "#" && $grid[$y][$x - 1] == "." && $grid[$y - 1][$x] == ".") {
            $jumpPoints[$y][$x]["L"] = 1;
            $jumpPoints[$y][$x]["D"] = 1;
        }

        if($y < $height - 1 && $x > 0 && $grid[$y + 1][$x - 1] == "#" && $grid[$y][$x - 1] == "." && $grid[$y + 1][$x] == ".") {
            $jumpPoints[$y][$x]["L"] = 1;
            $jumpPoints[$y][$x]["U"] = 1;
        }  

        if($y > 0 && $x < $width - 1 && $grid[$y - 1][$x + 1] == "#" && $grid[$y][$x + 1] == "." && $grid[$y - 1][$x] == ".") {
            $jumpPoints[$y][$x]["R"] = 1; 
            $jumpPoints[$y][$x]["D"] = 1;
        }  
        
        if($y < $height - 1 && $x < $width - 1 && $grid[$y + 1][$x + 1] == "#" && $grid[$y][$x + 1] == "." && $grid[$y + 1][$x] == ".") {
            $jumpPoints[$y][$x]["R"] = 1;
            $jumpPoints[$y][$x]["U"] = 1;
        } 

        $distances[$y][$x] = array_fill(0, 8, 0); //Set all distances to 0 by default
    }
}

//Mark westward distances
for($y = 0; $y < $height; ++$y) {

    $count = -1;
    $jumpSeen = -1;

    for($x = 0; $x < $width; ++$x) {
        if($grid[$y][$x] == "#") {
            $count = -1;
            $jumpSeen = -1;
            continue;
        }

        ++$count;

        $distances[$y][$x][6] = $count * $jumpSeen;

        if(isset($jumpPoints[$y][$x]["R"])) {
            $count = 0;
            $jumpSeen = 1;
        }
    }
}

//Mark eastward distances
for($y = 0; $y < $height; ++$y) {

    $count = -1;
    $jumpSeen = -1;

    for($x = $width - 1; $x >= 0; --$x) {
        if($grid[$y][$x] == "#") {
            $count = -1;
            $jumpSeen = -1;
            continue;
        }

        ++$count;

        $distances[$y][$x][2] = $count * $jumpSeen;

        if(isset($jumpPoints[$y][$x]["L"])) {
            $count = 0;
            $jumpSeen = 1;
        }
    }
}

//Mark northward distances
for($x = 0; $x < $width; ++$x) {

    $count = -1;
    $jumpSeen = -1;

    for($y = 0; $y < $height; ++$y) {
        if($grid[$y][$x] == "#") {
            $count = -1;
            $jumpSeen = -1;
            continue;
        }

        ++$count;

        $distances[$y][$x][0] = $count * $jumpSeen;

        if(isset($jumpPoints[$y][$x]["U"])) {
            $count = 0;
            $jumpSeen = 1;
        }
    }
}

//Mark southward distances
for($x = 0; $x < $width; ++$x) {

    $count = -1;
    $jumpSeen = -1;

    for($y = $height - 1; $y >= 0; --$y) {
        if($grid[$y][$x] == "#") {
            $count = -1;
            $jumpSeen = -1;
            continue;
        }

        ++$count;

        $distances[$y][$x][4] = $count * $jumpSeen;

        if(isset($jumpPoints[$y][$x]["D"])) {
            $count = 0;
            $jumpSeen = 1;
        }
    }
}

//Distance southeast
for($y = $height - 2; $y >= 0; --$y) {
    for($x = $width - 2; $x >= 0; --$x) {
        if($grid[$y][$x] == "#" || $grid[$y][$x + 1] == "#" || $grid[$y + 1][$x] == "#" || $grid[$y + 1][$x + 1] == "#") continue;

        if($distances[$y + 1][$x + 1][4] > 0 || $distances[$y + 1][$x + 1][2] > 0) $distances[$y][$x][3] = 1;
        else {
            $jumpDistance = $distances[$y + 1][$x + 1][3];

            $distances[$y][$x][3] = $jumpDistance + (($jumpDistance > 0) ? 1 : -1);
        }
    }
}

//Distance southwest 
for($y = $height - 2; $y >= 0; --$y) {
    for($x = 1; $x < $width; ++$x) {
        if($grid[$y][$x] == "#" || $grid[$y][$x - 1] == "#" || $grid[$y + 1][$x] == "#" || $grid[$y + 1][$x - 1] == "#") continue;

        if($distances[$y + 1][$x - 1][4] > 0 || $distances[$y + 1][$x - 1][6] > 0) $distances[$y][$x][5] = 1;
        else {
            $jumpDistance = $distances[$y + 1][$x - 1][5];

            $distances[$y][$x][5] = $jumpDistance + (($jumpDistance > 0) ? 1 : -1);
        }
    }
}

//Distance northeast  
for($y = 1; $y < $height; ++$y) {
    for($x = 0; $x < $width - 1; ++$x) {
        if($grid[$y][$x] == "#" || $grid[$y][$x + 1] == "#" || $grid[$y - 1][$x] == "#" || $grid[$y - 1][$x + 1] == "#") continue;

        if($distances[$y - 1][$x + 1][0] > 0 || $distances[$y - 1][$x + 1][2] > 0) $distances[$y][$x][1] = 1;
        else {
            $jumpDistance = $distances[$y - 1][$x + 1][1];

            $distances[$y][$x][1] = $jumpDistance + (($jumpDistance > 0) ? 1 : -1);
        }
    }
}

//Distance northwest  
for($y = 1; $y < $height; ++$y) {
    for($x = 1; $x < $width; ++$x) {
        if($grid[$y][$x] == "#" || $grid[$y][$x - 1] == "#" || $grid[$y - 1][$x] == "#" || $grid[$y - 1][$x - 1] == "#") continue;

        if($distances[$y - 1][$x - 1][0] > 0 || $distances[$y - 1][$x - 1][6] > 0) $distances[$y][$x][7] = 1;
        else {
            $jumpDistance = $distances[$y - 1][$x - 1][7];

            $distances[$y][$x][7] = $jumpDistance + (($jumpDistance > 0) ? 1 : -1);
        }
    }
}

foreach($distances as $y => $line) {
    foreach($line as $x => $info) {
        echo $x . " " . $y . " " . implode(" ", $info) . PHP_EOL;
    }
}

error_log(var_export(microtime(1) - $start, true)); 
?>
