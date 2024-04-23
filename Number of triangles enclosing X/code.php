<?php

class Point {
    public $x;
    public $y;
    public $name;

    function __construct(string $info) {
        [$this->name, $coord] = explode(" ", $info);
        [$this->x, $this->y] = array_map("floatval", explode(";", $coord));
    }
}

function area(Point $p1, Point $p2, Point $p3): float {
    return abs(($p1->x * ($p2->y - $p3->y) + $p2->x * ($p3->y - $p1->y) + $p3->x * ($p1->y - $p2->y)) / 2.0);
}

function isInside(Point $p1, Point $p2, Point $p3, Point $X): bool { 
     
    /* Calculate area of triangle ABC */
    $A = area($p1, $p2, $p3);
     
    /* Calculate area of triangle PBC */
    $A1 = area($X, $p2, $p3);
     
    /* Calculate area of triangle PAC */
    $A2 = area($p1, $X, $p3);
     
    /* Calculate area of triangle PAB */
    $A3 = area($p1, $p2, $X);

    /* Check if sum of A1, A2 and A3 is same as A */
    return (round($A, 8) == round($A1 + $A2 + $A3, 8));
}

$X = new Point(trim(fgets(STDIN)));

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    $points[] = new Point(trim(fgets(STDIN)));
}

$count = 0;

for($i1 = 0; $i1 < $N; ++$i1) {
    for($i2 = $i1 + 1; $i2 < $N; ++$i2) {
        for($i3 = $i2 + 1; $i3 < $N; ++$i3) {
            if(isInside($points[$i1], $points[$i2], $points[$i3], $X)) ++$count;
        }
    }
}

echo $count . PHP_EOL;
