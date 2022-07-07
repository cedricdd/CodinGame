<?php

$start = stream_get_line(STDIN, 100 + 1, "\n");
$end = stream_get_line(STDIN, 100 + 1, "\n");
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s %s", $station1, $station2);
    $links[$station1][] = $station2; 
    $links[$station2][] = $station1; 
}

error_log(var_export($start, true));
error_log(var_export($end, true));

$toCheck = [[$start, []]];

while(true) {
    $newCheck = [];

    foreach ($toCheck as $info) {
        list($position, $history) = $info;

        //Don't return to a station we have already been
        if(isset($history[$position])) continue;

        //Add the station to the history
        $history[$position] = 1;

        //Did we reach the target station
        if($position == $end) {
            echo implode(" > ", array_keys($history));
            exit();
        }

        //Check all the stations we can from current location
        foreach($links[$position] as $link) {
            $newCheck[] = [$link, $history];
        }
    }

    $toCheck = $newCheck;
}

?>
