<?php

for ($i = 0; $i < 6; $i++) {
    $map[] = stream_get_line(STDIN, 10 + 1, "\n");
}

//No fires
if(strpos(implode("", $map), "*") === false) echo "RELAX" . PHP_EOL;
else {
    for($y1 = 0; $y1 < 6; ++$y1) {
        for($x1 = 0; $x1 < 6; ++$x1) {
            if($map[$y1][$x1] == "*") {
                for($y2 = max($y1 - 2, 0); $y2 < min(6, $y1 + 3); ++$y2) {
                    for($x2 = max($x1 - 2, 0); $x2 < min(6, $x1 + 3); ++$x2) {
                        //Tree needs to be cut down
                        if($map[$y2][$x2] == "#") {
                            $map[$y2][$x2] = "C";
                        }
                    }
                }
            }
        }
    }

    error_log(var_export($map, true));

    if(strpos(implode("", $map), "#") === false) echo "JUST RUN" . PHP_EOL;
    else echo substr_count(implode("", $map), "C") . PHP_EOL;
} 
