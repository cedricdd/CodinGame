<?php

$original = [];
$revised = [];

fscanf(STDIN, "%s", $type);

fscanf(STDIN, "%d", $nbLinesV1);
for ($i = 0; $i < $nbLinesV1; $i++){
    $line = stream_get_line(STDIN, 200 + 1, "\n");
    $original[] = $line;
}

fscanf(STDIN, "%d", $nbLinesV2);
for ($i = 0; $i < $nbLinesV2; $i++) {
    $line = stream_get_line(STDIN, 200 + 1, "\n");
    $revised[] = $line;
}

$min = min($nbLinesV1, $nbLinesV2);
$max = max($nbLinesV1, $nbLinesV2);

$changes = [];

if($type == "BY_NUMBER") {
    for($i = 0; $i < $min; ++$i) {
        if($original[$i] != $revised[$i]) $changes[] = "CHANGE: " . $original[$i] . " ---> " . $revised[$i];
    }

    for($i = $min; $i < $max; ++$i) {
        if(!isset($original[$i])) $changes[] = "ADD: " . $revised[$i];
        else $changes[] = "DELETE: " . $original[$i];
    }
} else {
    $hashes = [];

    foreach($original as $index => $line) {
        $hashes[sha1($line)] = $index;
    }

    foreach($revised as $index => $line) {
        $hash = sha1($line);

        if(!isset($hashes[$hash])) $changes[] = "ADD: " . $line;
        else {
            if($hashes[$hash] != $index) $changes[] = "MOVE: " . $line . " @:" . ($hashes[$hash] + 1) . " >>> @:" . ($index + 1);

            unset($hashes[$hash]);
        }
    }

    foreach($hashes as $index) {
        $changes[] = "DELETE: " . $original[$index];
    }
}

sort($changes);

echo implode(PHP_EOL, $changes ?: ["No Diffs"]);
