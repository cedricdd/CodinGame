<?php

const MODULO = 10 ** 9 + 7;

function distancesum(array $arr): int {
    // sorting the array.
    sort($arr);
    $n = count($arr);
 
    // for each point, finding the distance.
    $res = 0; 
    $sum = 0;

    for ($i = 0; $i < $n; $i++) {
        $res += ($arr[$i] * $i - $sum);
        $sum += $arr[$i];
    }
 
    return $res;
}

/**
 * @param int $nRows The height of the image.
 * @param int $nCols The width of the image.
 * @param (string)[] $image Pixels of the image, given row by row from top to bottom. All pixel colors are alphanumeric.
 * @return The total length of wire needed to deploy the network (modulo 10^9+7)
 */
function getCableLength($nRows, $nCols, $image) {
    // Write your code here
    $result = 0;
    $start = microtime(1);

    for($y = 0; $y < $nRows; ++$y) {
        for($x = 0; $x < $nCols; ++$x) {
            $color = $image[$y][$x];
            
            $colors[$color]["x"][] = $x;
            $colors[$color]["y"][] = $y;
        }
    }

    //error_log(var_export($colors, true));

    foreach($colors as $color => ["x" => $x, "y" => $y]) {
        if(count($x) == 1) continue;

        $result += (distancesum($x) + distancesum($y));
        $result %= MODULO;
    }

    error_log(var_export($result, true));
    error_log(microtime(1) - $start);
    
    return ($result * 2) % MODULO;
}
