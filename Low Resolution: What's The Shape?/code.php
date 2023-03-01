<?php

$shape = "";

fscanf(STDIN, "%d %d", $W, $H);
for ($i = 0; $i < $H; $i++) {
    //Replace all the "grey" characters with the same symbol
    $shape .= preg_replace("/[^\.X]/", "*", trim(fgets(STDIN)));;
}

//Rectangle is just full X
if(substr_count($shape, "X") == $W * $H) echo "Rectangle" . PHP_EOL;
//Ellipse all the corners are the same
elseif($shape[0] == $shape[$W - 1] && $shape[0] == $shape[$W * $H - $W] && $shape[0] == $shape[$W * $H - 1]) echo "Ellipse" . PHP_EOL;
//All the rest is a triangle
else echo "Triangle" . PHP_EOL;
