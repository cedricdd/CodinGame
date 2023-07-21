<?php

//Rotate a given rotor $count times
function rotate(array $rotor, int $count = 1): array {
    foreach($rotor as $a => $b) {
        $rotated[($a - $count + 26) % 26] = ($b - $count + 26) % 26;
    }

    return $rotated;
}

for($i = 1; $i <= 3; ++$i) {
    foreach(explode(" ", trim(fgets(STDIN))) as $wire) {
        ${"rotors" . $i}[ord($wire[0]) - 65] = ord($wire[2]) - 65;
    }
    ${"trigger" . $i} = ord(trim(fgets(STDIN))) - 65;
}

foreach(explode(" ", trim(fgets(STDIN))) as $wire) {
    $reflector[ord($wire[0]) - 65] = ord($wire[2]) - 65;
}

foreach(explode(" ", fgets(STDIN)) as $i => $position) {
    $value = ord($position) - 65;

    $positions[$i] = $value;

    //Set the position of the rotors to their starting positions
    ${"rotors" . ($i + 1)} = rotate(${"rotors" . ($i + 1)}, $value);
}

$encrypted = "";
$rotate2 = false;
$rotate3 = false;

foreach(str_split(trim(fgets(STDIN))) as $c) {
    $value = (ord($c) - 65);

    //Rotate rotor 1
    $rotors1 = rotate($rotors1);
    $positions[0] = ($positions[0] + 1) % 26;

    $value = $rotors1[$value]; //Value after Rotor 1

    //Rotate rotor 2
    if($rotate2) {
        $rotors2 = rotate($rotors2);
        $positions[1] = ($positions[1] + 1) % 26;

        $rotate2 = false;
    }

    $value = $rotors2[$value]; //Value after Rotor 2

    if($positions[0] == $trigger1) $rotate2 = true;

    //Rotate rotor 3
    if($rotate3) {
        $rotors3 = rotate($rotors3);
        $positions[2] = ($positions[2] + 1) % 26;

        $rotate3 = false;
    }

    $value = $rotors3[$value]; //Value after Rotor 3

    if($positions[1] == $trigger2) $rotate2 = $rotate3 = true;

    $value = $reflector[$value]; //Value after Reflector

    $value = array_flip($rotors3)[$value]; //Value after Rotor 3 return

    $value = array_flip($rotors2)[$value]; //Value after Rotor 2 return

    $value = array_flip($rotors1)[$value]; //Value after Rotor 1 return

    $encrypted .= chr($value + 65);
}

echo $encrypted . PHP_EOL;
