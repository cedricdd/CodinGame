<?php

$grid = array_fill(0, 25, array_fill(0, 19, "{}"));
$alphabet = array_flip(range('a', 'z'));

foreach(explode(" ", stream_get_line(STDIN, 500 + 1, "\n")) as $instruction) {
    error_log(var_export($instruction, true)); 

    preg_match("/((?:PLANT|PLANTMOW)?)([a-z])([a-z])([0-9]{1,2})/", $instruction, $matches);

    $cx = $alphabet[$matches[2]];
    $cy = $alphabet[$matches[3]];
    $r = $matches[4] >> 1;

    for($y = max(0, $cy - $r); $y <= min(24, $cy + $r); ++$y) {
        for($x = max(0, $cx - $r); $x <= min(18, $cx + $r); ++$x) {
            //We are inside the circle
            if(sqrt(($cy - $y) ** 2 + ($cx - $x) ** 2) < $r + 0.5) { //Each position is 2 characters, we need to add 0.5 to the radius
                switch($matches[1]) {
                    case "PLANTMOW": $grid[$y][$x] = ($grid[$y][$x] == "{}") ? "  " : "{}"; break; //Reverse
                    case "PLANT": $grid[$y][$x] = "{}"; break;  //Plant
                    default: $grid[$y][$x] = "  ";  //Mow
                }   
            }
        }
    }
}

for($y = 0; $y < 25; ++$y) {
    echo implode("", $grid[$y]) . "\n";
}
?>
