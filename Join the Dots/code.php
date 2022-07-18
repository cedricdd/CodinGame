<?php

fscanf(STDIN, "%d %d", $H, $W);
for ($y = 0; $y < $H; ++$y) {
    $line = stream_get_line(STDIN, $W + 1, "\n");

    for($x = 0; $x < $W; ++$x) {
        if($line[$x] != ".") $positions[$line[$x]] = [$x, $y];
    }
}

$grid = array_fill(0, $H, str_repeat(" ", $W));

foreach(array_merge(range(1, 9), range('A', 'Z')) as $next) {
    if(!isset($positions[$next])) break; //We linked everything
    
    list($xn, $yn) = $positions[$next];
    $grid[$yn][$xn] = "o";

    if(isset($previous)) {
        list($xp, $yp) = $previous;

        if(($xn + $yn * $W) > ($xp + $yp * $W)) {
            $xs = $xp;  $ys = $yp; //Start
            $xe = $xn;  $ye = $yn; //End
        } else {
            $xs = $xn;  $ys = $yn; //Start
            $xe = $xp;  $ye = $yp; //End
        }

        //Vertical link
        if($xp == $xn) {
            for($y = $ys + 1; $y < $ye; ++$y) {
                $grid[$y][$xn] = (($grid[$y][$xn] == " ") ? "|" : (($grid[$y][$xn] == "-") ? "+" : "*"));
            }
        } //Horizontal link 
        elseif($yp == $yn) {
            for($x = $xs + 1; $x < $xe; ++$x) {
                $grid[$yn][$x] = (($grid[$yn][$x] == " ") ? "-" : (($grid[$yn][$x] == "|") ? "+" : "*"));
            }  
        } //Diagonal link 
        else {
            $mx = (($xe < $xs) ? -1 : 1);
            $my = (($ye < $ys) ? -1 : 1);

            do {
                $xs += $mx;
                $ys += $my;

                if(($xs == $xe && $ys == $ye)) break;

                $grid[$ys][$xs] = (($grid[$ys][$xs] == " ") ? (($mx + $my) ? "\\" : "/") : (($grid[$ys][$xs] == "\\" || $grid[$ys][$xs] == "/") ? "X" : "*"));
            } while(true);
        }
    }

    $previous = $positions[$next];
}

echo implode("\n", array_map("rtrim", $grid)) . "\n";
?>
