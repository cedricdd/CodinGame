<?php

function gcd ($a, $b) {
    return $b ? gcd($b, $a % $b) : $a;
}

$conversion = explode(" in ", stream_get_line(STDIN, 40 + 1, "\n"));
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    
    preg_match("/([0-9]+) (.+) = ([0-9]+) (.+)/", stream_get_line(STDIN, 40 + 1, "\n"), $matches);

    $relations[$matches[2]][$matches[4]] = [$matches[1], $matches[3]];
    $relations[$matches[4]][$matches[2]] = [$matches[3], $matches[1]];
}

$toCheck = [[$conversion[0], 1, 1]];
$checked = [];

while($toCheck) {

    list($unit, $n1, $n2) = array_pop($toCheck);

    //We reached the desired unit
    if($unit == $conversion[1]) break;

    //We already checked this unit
    if(isset($checked[$unit])) continue;
    else $checked[$unit] = 1;

    //Test all the relation we know for the current unit
    foreach($relations[$unit] as $name => $values) {
        $toCheck[] = [$name, $n1 * $values[0], $n2 * $values[1]];
    }
}

//We only want integer so we don't do division, for the output we have to divide by the gcd
$gcd = gcd($n1, $n2);

echo ($n1 / $gcd) . " " . $conversion[0] . " = " . ($n2 / $gcd) . " " . $conversion[1];
?>
