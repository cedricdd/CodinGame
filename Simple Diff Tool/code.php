<?php

fscanf(STDIN, "%s", $type);

fscanf(STDIN, "%d", $nbLinesV1);
for ($i = 0; $i < $nbLinesV1; $i++){
    $original[] = stream_get_line(STDIN, 200 + 1, "\n");
}

fscanf(STDIN, "%d", $nbLinesV2);
for ($i = 0; $i < $nbLinesV2; $i++) {
    $revised[] = stream_get_line(STDIN, 200 + 1, "\n");
}

$changes = [];
$count = max($nbLinesV1, $nbLinesV2);

if($type == "BY_NUMBER") {
    for($i = 0; $i < $count; ++$i) {
        if(!isset($original[$i])) $changes[] = "ADD: " . $revised[$i];
        elseif(!isset($revised[$i])) $changes[] = "DELETE: " . $original[$i];
        elseif($original[$i] != $revised[$i]) $changes[] = "CHANGE: " . $original[$i] . " ---> " . $revised[$i];
    }
}

sort($changes);

echo implode(PHP_EOL, $changes ?: ["No Diffs"]);
