<?php

$visited = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $x = 13;
    $y = 13;
    $z = -1; //We start on the surface not inside the tank

    foreach(str_split(trim(fgets(STDIN))) as $m) {
        switch($m) {
            case "U": $z -= 1; break;
            case "D": $z += 1; break;
            case "B": $y -= 1; break;
            case "F": $y += 1; break;
            case "L": $x -= 1; break;
            case "R": $x += 1; break;
        }

        //While the mouse is at the surface it doesn't remove any soil
        if($z > -1) $visited[$z . "-" . $y . "-" . $x] = 1;
    }
}

echo ((25*25*25) - count($visited)) . PHP_EOL;
