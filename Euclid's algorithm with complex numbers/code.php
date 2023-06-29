<?php

fscanf(STDIN, "%d %d", $xa, $ya);
fscanf(STDIN, "%d %d", $xb, $yb);

function formatComplex(int $x, int $y): string {
    if($x == 0) return $y . "j";
    else return "(" . $x . ($y >= 0 ? "+" : "") . $y . "j)";
}

//If there are two possible choices pick the highest one
function roundNumber(float $number): int {
    if($number > 0) return round($number, 0, PHP_ROUND_HALF_UP);
    else return round($number, 0, PHP_ROUND_HALF_DOWN);
}

function solve(int $xa, int $ya, int $xb, int $yb): string {
    //a/b => (a + i.b) / (a' + i.b') = (aa' + bb') + i (ba' - ab') / (a'² + b'²)
    $xq = roundNumber(($xa * $xb + $ya * $yb) / ($xb ** 2 + $yb ** 2));
    $yq = roundNumber(($ya * $xb - $xa * $yb) / ($xb ** 2 + $yb ** 2));

    //q * b => (a + i.b) x (a' + i.b') = (aa' – bb') + i (ab' + ba')
    $xr = $xq * $xb - $yq * $yb; 
    $yr = $xq * $yb + $yq * $xb;

    //a - (q * b) => (a + i.b) – (a' + i.b') = a – a' + i (b – b')
    $xr = $xa - $xr;
    $yr = $ya - $yr;

    echo formatComplex($xa, $ya) . " = " . formatComplex($xb, $yb) . " * " . formatComplex($xq, $yq) . " + " . formatComplex($xr, $yr) . PHP_EOL;

    //If rest is 0 we are done otherwier get the GCD of b & r
    if($xr == 0 && $yr == 0) return formatComplex($xb, $yb);
    else return solve($xb, $yb, $xr, $yr);
}

echo "GCD(" . formatComplex($xa, $ya) . ", " . formatComplex($xb, $yb) . ") = " . solve($xa, $ya, $xb, $yb) . PHP_EOL;
