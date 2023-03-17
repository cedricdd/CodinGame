<?php

fscanf(STDIN, "%d %d", $h, $w);
for ($i = 0; $i < $h; $i++) {
    $grid[] = trim(fgets(STDIN));
}

for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if($grid[$y][$x] == "+") {

            $x2 = $x;
            //Find all the "+" on the same row
            while(in_array(($grid[$y][++$x2] ?? "."), ["-", "+"])) {
                if($grid[$y][$x2] == "+") {
                    $links[$y * $w + $x]["x"][$y * $w + $x2] = 1;
                    $links[$y * $w + $x2]["x"][$y * $w + $x] = 1;
                }
            }

            $y2 = $y;
            //Find all the "+" on the same col
            while(in_array(($grid[++$y2][$x] ?? "."), ["|", "+"])) {
                if($grid[$y2][$x] == "+") {
                    $links[$y * $w + $x]["y"][$y2 * $w + $x] = 1;
                    $links[$y2 * $w + $x]["y"][$y * $w + $x] = 1;
                }
            }

            $x2 = $x;
            $y2 = $y;
            //Find all the "+" on the diagonal to the bottom right
            while(in_array(($grid[++$y2][++$x2] ?? "."), ["\\", "+"])) {
                if($grid[$y2][$x2] == "+") {
                    $links[$y * $w + $x]["d1"][$y2 * $w + $x2] = 1;
                    $links[$y2 * $w + $x2]["d1"][$y * $w + $x] = 1;
                }
            }

            $x2 = $x;
            $y2 = $y;
            //Find all the "+" on the diagonal to the bottom left
            while(in_array(($grid[++$y2][--$x2] ?? "."), ["/", "+"])) {
                if($grid[$y2][$x2] == "+") {
                    $links[$y * $w + $x]["d2"][$y2 * $w + $x2] = 1;
                    $links[$y2 * $w + $x2]["d2"][$y * $w + $x] = 1;
                }
            }
        }
    }
}

$triangles = 0;
$rectangles = 0;

foreach($links as $p1 => $info) {
    //Check if this point the the top left of a rectangle
    foreach(($info["x"] ?? []) as $p2 => $filler) {
        if($p2 < $p1) continue; //We only want points on the left

        foreach(($info["y"] ?? []) as $p3 => $filler) {
            if($p3 < $p1) continue; //We only want points on the bottom

            $p4 = $p3 + $p2 - $p1; //The last point of the rectable

            if(isset($links[$p3]["x"][$p4]) && isset($links[$p2]["y"][$p4])) ++$rectangles;
        }
    }

    //Check if point is part of a triangle
    foreach(($info["x"] ?? []) as $p2 => $filler) {
        if($p2 < $p1) continue;

        //Triangle on the top
        foreach(($links[$p1]["d2"] ?? []) as $p3 => $filler) {
            if($p3 > $p1) continue;

            if(isset($links[$p2]["y"][$p3]) || isset($links[$p2]["d1"][$p3])) ++$triangles;
        }
        foreach(($links[$p2]["d1"] ?? []) as $p3 => $filler) {
            if($p3 > $p1) continue;

            if(isset($links[$p1]["y"][$p3])) ++$triangles;
        }

        //Triangle on the bottom
        foreach(($links[$p1]["d1"] ?? []) as $p3 => $filler) {
            if($p3 < $p1) continue;

            if(isset($links[$p2]["y"][$p3]) || isset($links[$p2]["d2"][$p3])) ++$triangles;
        }
        foreach(($links[$p2]["d2"] ?? []) as $p3 => $filler) {
            if($p3 < $p1) continue;

            if(isset($links[$p1]["y"][$p3])) ++$triangles;
        }
    }

    foreach(($info["y"] ?? []) as $p2 => $filler) {
        if($p2 < $p1) continue;

        //Triangle on the left
        foreach(($links[$p1]["d2"] ?? []) as $p3 => $filler) {
            if($p3 < $p1) continue;

            if(isset($links[$p2]["d1"][$p3])) ++$triangles;
        }

        //Triangle on the right
        foreach(($links[$p1]["d1"] ?? []) as $p3 => $filler) {
            if($p3 < $p1) continue;

            if(isset($links[$p2]["d2"][$p3])) ++$triangles;
        }
    }
}

echo $triangles . PHP_EOL . $rectangles . PHP_EOL;
