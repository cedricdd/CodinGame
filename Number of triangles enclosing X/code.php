<?php

class Point {
    public $x;
    public $y;
    public $name;

    function __construct(string $info) {
        error_log($info);
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

function sign (Point $p1, Point $p2, Point $p3): float {
    return ($p1->x - $p3->x) * ($p2->y - $p3->y) - ($p2->x - $p3->x) * ($p1->y - $p3->y);
}

function PointInTriangle (Point $pt, Point $v1, Point $v2, Point $v3): bool {
    $d1 = sign($pt, $v1, $v2);
    $d2 = sign($pt, $v2, $v3);
    $d3 = sign($pt, $v3, $v1);

    $has_neg = ($d1 < 0) || ($d2 < 0) || ($d3 < 0);
    $has_pos = ($d1 > 0) || ($d2 > 0) || ($d3 > 0);

    return !($has_neg && $has_pos);
}

function ptInTriangle($p, $p0, $p1, $p2): bool {
    $s = ($p0->x - $p2->x) * ($p->y - $p2->y) - ($p0->y - $p2->y) * ($p->x - $p2->x);
    $t = ($p1->x - $p0->x) * ($p->y - $p0->y) - ($p1->y - $p0->y) * ($p->x - $p0->x);

    if (($s < 0) != ($t < 0) && $s != 0 && $t != 0)
        return false;

    $d = ($p2->x - $p1->x) * ($p->y - $p1->y) - ($p2->y - $p1->y) * ($p->x - $p1->x);
    return $d == 0 || ($d < 0) == ($s + $t <= 0);
}

$X = new Point(trim(fgets(STDIN)));


fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    $points[] = new Point(trim(fgets(STDIN)));
}

$count1 = 0;
$count2 = 0;
$count3 = 0;



for($i1 = 0; $i1 < $N; ++$i1) {
    for($i2 = $i1 + 1; $i2 < $N; ++$i2) {
        for($i3 = $i2 + 1; $i3 < $N; ++$i3) {
            if(ptInTriangle($X, $points[$i1], $points[$i2], $points[$i3])) {
                //error_log($points[$i1]->name . "-" . $points[$i2]->name . "-" . $points[$i3]->name);
                ++$count1;
            }
        }
    }
}


for($i1 = 0; $i1 < $N; ++$i1) {
    for($i2 = $i1 + 1; $i2 < $N; ++$i2) {
        for($i3 = $i2 + 1; $i3 < $N; ++$i3) {
            if(isInside($points[$i1], $points[$i2], $points[$i3], $X)) {
                //error_log($points[$i1]->name . "-" . $points[$i2]->name . "-" . $points[$i3]->name);
                ++$count2;
            }
        }
    }
}

for($i1 = 0; $i1 < $N; ++$i1) {
    for($i2 = $i1 + 1; $i2 < $N; ++$i2) {
        for($i3 = $i2 + 1; $i3 < $N; ++$i3) {
            if(PointInTriangle($X, $points[$i1], $points[$i2], $points[$i3])) {
                //error_log($points[$i1]->name . "-" . $points[$i2]->name . "-" . $points[$i3]->name);
                ++$count3;
            }
        }
    }
}

error_log("$count1 $count2 $count3");
echo $count1 . PHP_EOL;
