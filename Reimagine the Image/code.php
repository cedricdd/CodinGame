<?php

fscanf(STDIN, "%d", $H);
fscanf(STDIN, "%d", $W);

for ($i = 0; $i < $H; $i++) {
    $image[] = stream_get_line(STDIN, 100 + 1, "\n");
}

error_log(var_export($image, 1));

for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        //Filling the |
        if($y < $H - 2 && $image[$y][$x] == '|' && $image[$y + 1][$x] == ' ') {
            $empty = [];

            $y2 = $y + 1;

            while($y2 < $H) {
                if($image[$y2][$x] == ' ') $empty[] = $y2;
                else {
                    if($image[$y2][$x] == '|') {
                        foreach($empty as $y2) $image[$y2][$x] = '|';
                    }
                    break;
                }

                ++$y2;
            }
        }

        //Filling the _
        if($x < $W - 2 && $image[$y][$x] == "_" && $image[$y][$x + 1] == ' ') {
            $empty = [];

            $x2 = $x + 1;

            while($x2 < $W) {
                if($image[$y][$x2] == ' ' && ($y == $H - 1 || $image[$y + 1][$x2] != '|')) $empty[] = $x2;
                else {
                    if($image[$y][$x2] == '_') {
                        foreach($empty as $x2) $image[$y][$x2] = '_';
                    }
                    break;
                }

                ++$x2;
            }
        }

        //Filling the \
        if($x < $W - 2 && $y < $H - 2 && $image[$y][$x] == '\\' && $image[$y + 1][$x + 1] == ' ') {
            $empty = [];

            $y2 = $y + 1;
            $x2 = $x + 1;

            while($y2 < $H && $x2 < $W) {
                if($image[$y2][$x2] == ' ') $empty[] = [$x2, $y2];
                else {
                    if($image[$y2][$x2] == '\\') {
                        foreach($empty as [$x2, $y2]) $image[$y2][$x2] = '\\';
                    }
                    break;
                }

                ++$x2;
                ++$y2;
            }
        }

        //Filling the /
        if($x > 1 && $y < $H - 2 && $image[$y][$x] == '/' && $image[$y + 1][$x - 1] == ' ') {
            $empty = [];

            $y2 = $y + 1;
            $x2 = $x - 1;

            while($y2 < $H && $x2 >= 0) {
                if($image[$y2][$x2] == ' ') $empty[] = [$x2, $y2];
                else {
                    if($image[$y2][$x2] == '/') {
                        foreach($empty as [$x2, $y2]) $image[$y2][$x2] = '/';
                    }
                    break;
                }

                --$x2;
                ++$y2;
            }
        }
    }
}

echo implode(PHP_EOL, $image) . PHP_EOL;
