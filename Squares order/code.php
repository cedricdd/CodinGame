<?php

const DIRECTIONS = [[1, 0], [0, 1], [-1, 0], [0, -1]];

function getConflicts(int $n, array $corners): array {
    global $w, $h, $grid1, $counts;

    //We have at least two corners, we know the size
    if(count($corners) > 1) {
        [$x1, $y1] = reset($corners);
        [$x2, $y2] = end($corners);

        $size = max(abs($x1 - $x2) + 1, abs($y1 - $y2) + 1);
    } else $size = null;

    //Just use the first corner
    $type = array_key_first($corners);
    [$x, $y] = $corners[$type];

    if($type == "TL") {
        if($size === null) {
            $min = 2;
            $max = min($w - $x, $h - $y);
        } else $min = $max = $size;

        $direction = 0;
    } elseif($type == "TR") {
        if($size === null) {
            $min = 2;
            $max = min($x + 1, $h - $y);
        } else $min = $max = $size;

        $direction = 1;
    } elseif($type == "BR") {
        if($size === null) {
            $min = 2;
            $max = min($x + 1, $y + 1);
        } else $min = $max = $size;

        $direction = 2;
    } elseif($type == "BL") {
        if($size === null) {
            $min = 2;
            $max = min($w - $x, $y + 1);
        } else $min = $max = $size;

        $direction = 3;
    }

    //Test all the possible sizes for this square
    for($size = $min; $size <= $max; ++$size) {
        $digits = array_fill(1, 9, 0);

        //Starting position & direction
        $cx = $x;
        $cy = $y;
        $cd = $direction;

        for($d = 0; $d < 4; ++$d) {
            for($i = 1; $i < $size; ++$i) {
                if(($grid1[$cy += DIRECTIONS[$cd][1]][$cx += DIRECTIONS[$cd][0]] ?? '0') == 0) continue 3; //Wrong size for the square
                else $digits[$grid1[$cy][$cx]]++;
            }

            $cd = ($cd + 1) % 4;
        }

        //We are not using digits on the grid, wrong size for the square
        if($digits[$n] != $counts[$n]) continue;

        $digits = array_filter($digits); //We don't care about the 0 values

        unset($digits[$n]); //The digits of the current square don't prevent it from being drawn

        return [$size, $digits];
    }
}

fscanf(STDIN, "%d %d", $h, $w);
fscanf(STDIN, "%d", $nb);

$counts = array_fill(0, 10, 0);
$grid1 = array_fill(0, $h, str_repeat('0', $w));
$grid2 = array_fill(0, $w, str_repeat('0', $h));

for ($y = 0; $y < $h; ++$y) {
    foreach(str_split(str_replace('.', '0', trim(fgets(STDIN)))) as $x => $c) {
        $grid1[$y][$x] = $c;
        $grid2[$x][$y] = $c;
        $counts[$c]++;
    }
}

$counts = array_filter($counts);

for($i = 1; $i <= $nb; ++$i) {
    //Find the horizontal sides of the square
    for ($y = 0; $y < $h; ++$y) {
        preg_match("/[$i]{2,}/", $grid1[$y], $match, PREG_OFFSET_CAPTURE);

        if(isset($match[0])) $sideH[$i][] = [$y, $match[0][1]];
    }

    //Find the vertical sides of the square
    for ($x = 0; $x < $w; ++$x) {
        preg_match("/[$i]{2,}/", $grid2[$x], $match, PREG_OFFSET_CAPTURE);

        if(isset($match[0])) $sideV[$i][] = [$x, $match[0][1]];
    }
}

for($n = 1; $n <= $nb; ++$n) {
    $corners = [];

    //We only have one horizontal side, mark it as the bottom left corner
    if(!isset($sideV[$n])) {
        $corners["BL"] = array_reverse(reset($sideH[$n]));
    } else {
        //Generate the corners
        foreach($sideV[$n] as [$x, $xs]) {
            foreach($sideH[$n] as [$y, $ys]) {
                //It's a bottom corner
                if($xs < $y) {
                    if($ys < $x) $type = "BR";
                    else $type = "BL";
                } //It's a top corner
                else {
                    if($ys < $x) $type = "TR";
                    else $type = "TL";
                }
    
                $corners[$type] = [$x, $y];
            }
        }
    }

    [$sizes[$n], $constraints[$n]] = getConflicts($n, $corners);
}

//The next square is the one with no constraint left
for($i = 0; $i < $nb; ++$i) {
    foreach($constraints as $n => $list) {
        if(count($list) == 0) {
            $output[] = $n . " " . $sizes[$n];

            unset($constraints[$n]);

            foreach($constraints as $n2 => &$list2) unset($list2[$n]); //This square is no longer a constraint for any of the others

            continue 2;
        }
    }
}

//We currently have the list from last to first
echo implode(PHP_EOL, array_reverse($output)) . PHP_EOL;
