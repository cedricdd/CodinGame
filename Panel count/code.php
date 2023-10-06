<?php

$properties[] = "Name";

fscanf(STDIN, "%d", $P);
for ($i = 0; $i < $P; $i++) {
    $properties[] = trim(fgets(STDIN));
}

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $infos = explode(" ", trim(fgets(STDIN)));

    foreach($infos as $index => $info) $person[$properties[$index]] = $info;

    $persons[] = $person;
}

fscanf(STDIN, "%d", $F);
for ($i = 0; $i < $F; $i++) {
    $formula = explode(" AND ", trim(fgets(STDIN)));

    $filteredPersons = $persons;

    //Just remove all the persons that don't match the formula
    foreach($formula as $check) {
        [$prop, $value] = explode("=", $check);

        foreach($filteredPersons as $index => $infos) {
            if(($infos[$prop] ?? "") != $value) unset($filteredPersons[$index]);
        }
    }

    echo count($filteredPersons) . PHP_EOL;
}
