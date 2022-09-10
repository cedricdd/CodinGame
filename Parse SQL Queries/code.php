<?php

$sqlQuery = stream_get_line(STDIN, 256 + 1, "\n");
fscanf(STDIN, "%d", $ROWS);
$headers = array_flip(explode(" ", trim(fgets(STDIN))));

for ($i = 0; $i < $ROWS; $i++) {
    $values[] = explode(" ", trim(fgets(STDIN)));
}

preg_match("/SELECT (.*) FROM \w+(?: WHERE ([^\s]*) = ([^\s]*))?(?: ORDER BY ([^\s]*) (DESC|ASC))?/", $sqlQuery, $matches);

//We are filtering the results
if(isset($matches[2]) && !empty($matches[2])) {
    foreach($values as $i => $info) {
        if($info[$headers[$matches[2]]] != $matches[3]) unset($values[$i]);
    }
}

//We are sorting the results
if(isset($matches[4])) {
    [$columnID, $order] = [$headers[$matches[4]], $matches[5]];

    usort($values, function($a, $b) use ($columnID, $order) {
        if($order != "DESC") return $a[$columnID] <=> $b[$columnID];
        else return $b[$columnID] <=> $a[$columnID];
    });
}

//We are selecting specific columns
if($matches[1] != "*") {
    $selectedColmuns = explode(", ", $matches[1]);

    foreach($headers as $name => $position) {
        if(!in_array($name, $selectedColmuns)) unset($headers[$name]);
    }
}


echo implode(" ", array_flip($headers)) . PHP_EOL;
foreach($values as $info) {
    $output = [];

    //Select the column to return in the proper order
    foreach($headers as $position) $output[] = $info[$position];

    echo implode(" ", $output) . PHP_EOL;
}
?>
