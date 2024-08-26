<?php

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $E);

for ($i = 0; $i < $N; $i++) {
    [$name, $effective, $ineffective] = explode(",", trim(fgets(STDIN)));

    $effective = $effective != "None" ? explode(" ", $effective) : [];
    $ineffective = $ineffective != "None" ? explode(" ", $ineffective) : [];

    $types[$name] = [$effective, $ineffective];
}

for ($i = 0; $i < $E; $i++) {
    $attacks = [];

    $enemy = array_flip(explode(" ", trim(fgets(STDIN))));

    //Check all types against that ennemy
    foreach($types as $name => [$effective, $ineffective]) {
        $value = 1;

        foreach($effective as $type) {
            //That type is effective againt the ennemy
            if(isset($enemy[$type])) $value *= 2;
        }
        foreach($ineffective as $type) {
            //That type isn't effective against that ennemy
            if(isset($enemy[$type])) $value /= 2;
        }

        $attacks[$value][] = $name;
    }

    ksort($attacks); //Sort types by efficiency

    echo implode(" ", array_pop($attacks)) . PHP_EOL; 
}
