<?php

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d %d", $h, $w);
for ($y = 0; $y < $h; ++$y) {
    $grid[] = trim(fgets(STDIN));

    foreach(str_split($grid[$y]) as $x => $c) {
        if($c == "o") {
            $partial[$y * $w + $x] = [$x, $y];
            $grid[$y][$x] = "O"; //Mark it as a bumbbell part we haven't used yet
        }
    }
}

error_log(var_export($grid, true));

while($partial) {
    $onlyPartial = ($n * 2 == count($partial)); //All the dumbbells left to found are only composed of partial dumbbell

    foreach($partial as $index => [$x, $y]) {
        $direction["T"] = ($y >= 2 && $grid[$y - 1][$x] == "." && ((!$onlyPartial && $grid[$y - 2][$x] == ".") || $grid[$y - 2][$x] == "O")) ? 1 : 0;
        $direction["B"] = ($y < $h - 2 && $grid[$y + 1][$x] == "." && ((!$onlyPartial && $grid[$y + 2][$x] == ".") || $grid[$y + 2][$x] == "O")) ? 1 : 0;
        $direction["L"] = ($x >= 2 && $grid[$y][$x - 1] == "." && ((!$onlyPartial && $grid[$y][$x - 2] == ".") || $grid[$y][$x - 2] == "O")) ? 1 : 0;
        $direction["R"] = ($x < $w - 2 && $grid[$y][$x + 1] == "." && ((!$onlyPartial && $grid[$y][$x + 2] == ".") || $grid[$y][$x + 2] == "O")) ? 1 : 0;

        $direction = array_filter($direction);

        //This can only be part of a bumbell in a single direction
        if(count($direction) == 1) {
            switch(array_key_first($direction)) {
                case "T":
                    $grid[$y - 1][$x] = "|";
                    $grid[$y - 2][$x] = "o";
                    unset($partial[$index - ($w * 2)]);
                    break;
                case "B":
                    $grid[$y + 1][$x] = "|";
                    $grid[$y + 2][$x] = "o";
                    unset($partial[$index + ($w * 2)]);
                    break;
                case "L":
                    $grid[$y][$x - 1] = "-";
                    $grid[$y][$x - 2] = "o";
                    unset($partial[$index - 2]);
                    break;
                case "R":
                    $grid[$y][$x + 1] = "-";
                    $grid[$y][$x + 2] = "o";
                    unset($partial[$index + 2]);
                    break;
            }

            $grid[$y][$x] = "o";
            unset($partial[$index]);
            --$n;

            continue 2; //Force a refrech of the foreach
        }
    }
}

//We have used all the partial dumbbells but we are still missing some, since all solutions are unique just add more everywhere it's possible
while($n > 0) {
    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            if($grid[$y][$x] != ".") continue;

            //Enough horizontal space to add one
            if($x >= 2 && $grid[$y][$x - 1] == "." && $grid[$y][$x - 2] == ".") {
                --$n;
                $grid[$y][$x] = $grid[$y][$x - 2] = "o";
                $grid[$y][$x - 1] = "-";
            } //Enough vertical space to add one
            elseif($y >= 2 && $grid[$y - 1][$x] == "." && $grid[$y - 2][$x] == ".") {
                --$n;
                $grid[$y][$x] = $grid[$y - 2][$x] = "o";
                $grid[$y - 1][$x] = "|";
            }
        }
    }
}

echo implode("\n", $grid) . PHP_EOL;
