<?php

$rules = [];

foreach(explode(" ", trim(fgets(STDIN))) as $rule) {
    [$oldCharacter, $newCharacter] = str_split($rule);

    if($oldCharacter == $newCharacter) continue;
    if(isset($rules[$newCharacter])) {
        if($rules[$newCharacter] == $oldCharacter) die("ERROR"); //Loop
        else $newCharacter = $rules[$newCharacter];
    }
    
    //Update existing rules
    foreach($rules as $oc => $nc) {
        if($oc == $oldCharacter) {
            if($nc == $newCharacter) continue 2; //Same rule as what we already have
            else die("ERROR"); //Several patterns for a single character
        }
        if($nc == $oldCharacter) $rules[$oc] = $newCharacter;
    }

    //Add new rule
    $rules[$oldCharacter] = $newCharacter;
}

fscanf(STDIN, "%d", $n);

$string = "";

for ($i = 0; $i < $n; $i++) {
    $string .= trim(fgets(STDIN));
}

foreach($rules as $from => $to) {
    $string = str_replace($from, $to, $string);
}

echo implode("\n", str_split($string, $n)) . PHP_EOL;
?>
