<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++){
    $room = explode(' ', stream_get_line(STDIN, 256 + 1, "\n"));
    $rooms[$room[0]] = [$room[1], $room[2], $room[3]];
}

//error_log(var_export($rooms, true));

function compute(&$rooms, $room) {
    //Bender has exit the building
    if($room === "E")  return 0;

    list($amount, $d1, $d2) = $rooms[$room];

    //We haven't found the best for this room yet
    if(!isset($rooms[$room][3])) $rooms[$room][3] = max(compute($rooms, $d1), compute($rooms, $d2));

    return $amount + $rooms[$room][3];
}

echo compute($rooms, 0) . "\n";
?>
