<?php
$array = [];

function getValue($string) {
    global $array;

    if(is_numeric($string)) return intval($string);
    else {
        preg_match("/([A-Z]+)\[(.+)\]/", $string, $match);
        return $array[$match[1]][getValue($match[2])];
    }
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $assignment = stream_get_line(STDIN, 1024 + 1, "\n");

    //Get all the values from the input we need to create the array
    preg_match("/([A-Z]+)\[([\-0-9]+)..([\-0-9]+)\] = ([0-9 \-]+)/", $assignment, $match);

    //Create the array
    $array[$match[1]] = array_combine(range($match[2], $match[3]), explode(" ", $match[4]));
}

//error_log(var_export($array, true)); 

echo getValue(stream_get_line(STDIN, 256 + 1, "\n"));
?>
