<?php

//Flip an array diagonally 
function flipDiagonally($arr) {
    $out = array();
    foreach ($arr as $key => $subarr) {
        foreach (str_split($subarr) as $subkey => $subvalue) {
            $out[$subkey] = ($out[$subkey] ?? "") . $subvalue;
        }
    }
    return $out;
}

fscanf(STDIN, "%d", $H);
for ($i = 0; $i < $H; $i++) {
    //Lets simply preg_match as '.', '\' and '/' are special characters, replace them with simple letters
    $line = strtr(stream_get_line(STDIN, 128 + 1, "\n"), "./\\", "xlr");

    /*
    * Search for:
    * - a "/" card is missing before a "\" card => xr
    * - a "\" card is missing after a "/" card => lx
    * - two cards side by side have the same orientation => ll or rr
    */
    preg_match("/xr|lx|ll|rr/", $line, $match);

    if(count($match)) exit("UNSTABLE\n");

    $map[] = $line;
}

$map = flipDiagonally($map);

/*
 * Search for:
 * - neither another card nor the ground are below => lx or rx
 * - the card below has the same orientation => ll or rr
 */
for($y = 0; $y < $H * 2; ++$y) {
    preg_match("/ll|rr|lx|rx/", $map[$y], $match);

    if(count($match)) exit("UNSTABLE\n");
}

echo "STABLE\n";
?>
