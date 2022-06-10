<?php
/**
 * Don't let the machines win. You are humanity's last hope...
 **/

// $width: the number of cells on the X axis
fscanf(STDIN, "%d", $width);
// $height: the number of cells on the Y axis
fscanf(STDIN, "%d", $height);

$gridX = [];
$gridY = [];

for ($i = 0; $i < $height; $i++)
{
    $gridX[$i] = stream_get_line(STDIN, 31 + 1, "\n");// width characters, each either 0 or .
    foreach (str_split($gridX[$i]) as $key => $value) {
        if (key_exists($key, $gridY)) $gridY[$key].= $value;
        else $gridY[$key]= $value;  
    } 
}

for($y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x) {
        if($gridX[$y][$x] !== '0') continue;

        $left = strpos(substr($gridX[$y], $x +1), '0');
        $bottom = strpos(substr($gridY[$x], $y +1), '0');

        echo $x . " " . $y . " " . ($left !== FALSE ? ($left + $x + 1) . " " . $y : '-1 -1') . " " . ($bottom !== FALSE ? $x . " " . ($bottom + $y + 1) : '-1 -1') . "\n";
    }
}

// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug: error_log(var_export($var, true)); (equivalent to var_dump)
?>
