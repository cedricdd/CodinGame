<?php

$original = [];
$revised = [];

fscanf(STDIN, "%s", $type);

fscanf(STDIN, "%d", $nbLinesV1);
for ($i = 0; $i < $nbLinesV1; $i++){
    $line = stream_get_line(STDIN, 200 + 1, "\n");
    $original[sha1($line)] = $line;
}

fscanf(STDIN, "%d", $nbLinesV2);
for ($i = 0; $i < $nbLinesV2; $i++) {
    $line = stream_get_line(STDIN, 200 + 1, "\n");
    $revised[sha1($line)] = $line;
}

$changes = [];

if($type == "BY_NUMBER") {
    reset($original);
    reset($revised);

    while(current($original) || current($revised)) {
        if(!current($original)) $changes[] = "ADD: " . current($revised);
        elseif(!current($revised)) $changes[] = "DELETE: " . current($original);
        elseif(current($original) != current($revised)) $changes[] = "CHANGE: " . current($original) . " ---> " . current($revised);

        next($original);
        next($revised);
    }
} else {
    foreach($original as $hash => $line) {
        if(!isset($revised[$hash])) $changes[] = "DELETE: " . $line;
    }

    foreach($revised as $hash => $line) {
        if(!isset($original[$hash])) $changes[] = "ADD: " . $line;
    }
}

sort($changes);

echo implode(PHP_EOL, $changes ?: ["No Diffs"]);
