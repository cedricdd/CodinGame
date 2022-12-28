<?php

for ($y = 0; $y < 5; $y++) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $c) {
        $keys[$c] = [$x, $y];
        $keys2[$y][$x] = $c;
    }
}

$shift = (trim(fgets(STDIN)) == "ENCRYPT") ? 1 : 4;

fscanf(STDIN, "%d", $N);
for ($j = 0; $j < $N; $j++) {
    //Change to upper case & remove characters not present in the key table
    $message = preg_replace("/[^" . implode("", array_keys($keys)) . "]/", "", strtoupper(trim(fgets(STDIN))));

    //Wrong length of message
    if(strlen($message) & 1) {
        echo "DUD" . PHP_EOL;
        continue;
    }

    $decoded = "";

    for($i = 0; $i < strlen($message); $i += 2) {
        [$xa, $ya] = $keys[$message[$i]];
        [$xb, $yb] = $keys[$message[$i + 1]];

        //Same row
        if($ya == $yb) $decoded .= $keys2[$ya][($xa + $shift) % 5] . $keys2[$yb][($xb + $shift) % 5];
        //Same col
        elseif($xa == $xb) $decoded .= $keys2[($ya + $shift) % 5][$xa] . $keys2[($yb + $shift) % 5][$xb];
        //Imaginary rectangle
        else $decoded .= $keys2[$ya][$xb] . $keys2[$yb][$xa];
    }

    echo $decoded . PHP_EOL; 
}
