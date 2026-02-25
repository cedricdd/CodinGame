<?php

fscanf(STDIN, "%d %d", $w, $h);
for ($i = 0; $i < $h; $i++) {
    $mountains[] = array_map('intval', explode(" ", trim(fgets(STDIN))));
}

fscanf(STDIN, "%d %d", $a, $b);
fscanf(STDIN, "%d", $t);

$result = PHP_INT_MAX;

//Avoid duplicate orientation if square
$rectangles = ($a === $b) ? [[$a, $b]] : [[$a, $b], [$b, $a]];

for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        foreach($rectangles as [$xm, $ym]) {
            //Not enough space for the rectangle to start here
            if($x + $xm > $w || $y + $ym > $h) continue;

            $count = 0;
            $min = PHP_INT_MAX;
            $total = 0;

            //Find how many shots we need by doing only one pass
            for($i = 0; $i < $ym; ++$i) {
                for($j = 0; $j < $xm; ++$j) {
                    $height = $mountains[$y + $i][$x + $j];

                    //We have a new min height
                    if($height < $min) {
                        $total += $count * ($min - $height); //How much we need to remove from all the previous height
                        $min = $height;
                    } else {
                        $total += $height - $min; //Removing to reach the current min
                    }

                    if($total > $t || $total > $result) continue 3;

                    ++$count;
                }
            }

            $result = $total;
        }
    }
}

if($result == PHP_INT_MAX) echo "Not Possible" . PHP_EOL;
else echo $result . PHP_EOL;
