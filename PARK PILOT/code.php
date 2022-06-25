<?php
/**
 * Find empty park lot for current vehicle
 **/

$fl = $fr = "";
$br = $bl = "";

// $N: Road length
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $sensors = stream_get_line(STDIN, 4 + 1, "\n");// Datas from four sensor with values 1 or 0 (e.g 1001)

    $fl .= $sensors[0]; 
    $fr .= $sensors[1]; 
    $br .= $sensors[2];
    $bl .= $sensors[3]; 
}

error_log(var_export("fl " . $fl, true));
error_log(var_export("fr " . $fr, true));
error_log(var_export("dl " . $bl, true));
error_log(var_export("dr " . $br, true));

$carSize = strpos($bl, '0') - strpos($fl, '0') + 1; //Can't park near the entrance so we can use the first 0

//Positions on the left
preg_match_all("/(?=(0{" . $carSize . "}))/", $fl, $matches, PREG_OFFSET_CAPTURE);

foreach ($matches[1] as $match) {
    $positions[$match[1] + ($carSize - 1) * 2] = "L";
}

//Positions on the right
preg_match_all("/(?=(0{" . $carSize . "}))/", $fr, $matches, PREG_OFFSET_CAPTURE);

foreach ($matches[0] as $match) {
    $positions[$match[1] + ($carSize - 1) * 2] = "R";
}

//Output in acending order
ksort($positions);

echo $carSize . "\n";
foreach($positions as $key => $side) echo $key . $side . "\n";
?>
