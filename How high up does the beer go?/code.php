<?php

fscanf(STDIN, "%f %f %f %f", $bottomRadius, $topRadius, $glassHeight, $beerVol);

//Calculate the slant height of the truncated cone, just Pythagoras' theorem
$slantHeight = sqrt($glassHeight ** 2 + ($bottomRadius - $topRadius) ** 2);

//We just test all the height until the volume is big enough to contain the beer volume
for($h = 0.1; $h < $glassHeight; $h += 0.01) {
    //Calculate the slant height at the given height, we use Triangle Proportionality Theorem 
    $slant = ($h * $slantHeight) / $glassHeight;
    //Calculate the radius of the cone at $h, again just Pythagoras' theorem
    $radius = sqrt(($slant ** 2) - ($h ** 2)) + $bottomRadius;
    //We use the formula to calculate the volume at $h
    $v = (1/3) * pi() * $h * ($bottomRadius ** 2 + $bottomRadius * $radius + $radius ** 2);

    if($v >= $beerVol) exit(number_format($h, 1));
}
