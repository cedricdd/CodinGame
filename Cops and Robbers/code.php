<?php

$input = unpack('C*', trim(fgets(STDIN)));
$cop = implode("-", array_slice($input, 0, 4));
$robber = implode("-", array_slice($input, 4, 4));

fscanf(STDIN, "%d", $h);
for ($y = 0; $y < $h; ++$y) {
    foreach(array_chunk(unpack('C*', trim(fgets(STDIN))), 4) as $x => $input) {
        $emoji = implode("-", $input);

        //Save the positions of all the cops & robbers
        if($emoji == $cop) $cops[] = [$x, $y];
        elseif($emoji == $robber) $robbers[] = [$x, $y];
    }
}

$answer = INF;

foreach($cops as [$xc, $yc]) {
    foreach($robbers as [$xr, $yr]) {
        $answer = min($answer, round(sqrt(($xc - $xr) ** 2 + ($yc - $yr) ** 2) * 10));
    }
}

echo $answer . PHP_EOL;
