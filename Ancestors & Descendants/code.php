<?php
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; ++$i) {
    $line = trim(fgets(STDIN));

    $name = ltrim($line, "."); //Name of the person
    $count = strlen($line) - strlen($name); //Numbers of dots

    $path = $name;

    if($count > 0) {
        //Find his direct ancestor
        for($j = $i - 1; $j >= 0; --$j) {
            if($inputs[$j][0] == $count - 1) {
                $path = $inputs[$j][2] . " > " . $name; //Path to the current person
                $inputs[$j][3] = false; //This person has descendants
                break;
            }
        }
    }

    $inputs[] = [$count, $name, $path, true];
}

//Show the path of all the person that have no descendants
foreach($inputs as [, , $path, $final]) {
    if($final) echo $path . PHP_EOL;
}
