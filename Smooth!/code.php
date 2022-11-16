<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $F);

    //We have to reach 1 by dividing by 5, 3 or 2. If we can't divide by any of these the game can't be won.
    while($F > 1) {
        if($F % 5 == 0) $F /= 5;
        elseif($F % 3 == 0) $F /= 3;
        elseif($F % 2 == 0) $F /= 2;
        else {
            echo "DEFEAT" . PHP_EOL;
            continue 2;
        }
    }

    echo "VICTORY" . PHP_EOL;
}
