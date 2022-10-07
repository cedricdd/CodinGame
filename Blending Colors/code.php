<?php

//Check a point against a square
function checkSquare(int $x0, int $y0, int $len, int $x, int $y): array {

    //On horizontal border
    if(($x == $x0 || $x == ($x0 + $len)) && $y >= $y0 && $y <= ($y0 + $len)) return [true, false];
    //On vertical border
    if(($y == $y0 || $y == ($y0 + $len)) && $x >= $x0 && $x <= ($x0 + $len)) return [true, false];
    //Inside the square
    if($x > $x0 && $x < ($x0 + $len) && $y > $y0 && $y < ($y0 + $len)) return [false, true];
    
    return [false, false];
}

//Check a point against a circle
function checkCircle(int $x0, int $y0, int $len, int $x, int $y): array {

    $distance = sqrt(pow($x - $x0, 2) + pow($y - $y0, 2));

    //Point is on the border
    if($distance == $len) return [true, false];
    //Point is inside the circle
    if($distance < $len) return [false, true];

    return [false, false];
}

fscanf(STDIN, "%d %d", $S, $P);
for ($i = 0; $i < $S; $i++) {
    $shapes[] = explode(" ", trim(fgets(STDIN))); 
}

for ($i = 0; $i < $P; $i++){
    fscanf(STDIN, "%d %d", $x, $y);

    $sumR = 0; $sumG = 0; $sumB = 0;
    $count = 0;

    foreach($shapes as [$type, $x0, $y0, $len, $r, $g, $b]) {
        //Check the point against that shape
        [$isOnBorder, $isInside] = call_user_func("check" . ucfirst(strtolower($type)), $x0, $y0, $len, $x, $y);

        //Point is on the border, black doesn't blend in so it will stay black
        if($isOnBorder) {
            echo "(0, 0, 0)" . PHP_EOL;
            continue 2;
        }

        if($isInside) {
            $sumR += $r;
            $sumG += $g;
            $sumB += $b;
            ++$count;
        }
    }

    if($count == 0) echo "(255, 255, 255)" . PHP_EOL;
    else echo "(" . round($sumR / $count) . ", " . round($sumG / $count) . ", " . round($sumB / $count) . ")" . PHP_EOL;
}
?>
