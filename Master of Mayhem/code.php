<?php

fscanf(STDIN, "%d", $cyborgCount);
for ($i = 0; $i < $cyborgCount; $i++) {
    fscanf(STDIN, "%s", $cyborgs[]);
}

$cyborgs = array_flip($cyborgs);

fscanf(STDIN, "%d", $mayhemReportCount);
for ($i = 0; $i < $mayhemReportCount; $i++) {
    $mayhemReport = stream_get_line(STDIN, 100 + 1, "\n");

    preg_match("/Mayhem's ([a-z]+) is (?:an |a )?([a-zA-Z ]+)/", str_replace("\"", "", $mayhemReport), $matches);

    $info[$matches[1]] = $matches[2];
}

fscanf(STDIN, "%d", $cyborgReportCount);
for ($i = 0; $i < $cyborgReportCount; $i++) {
    $cyborgReport = stream_get_line(STDIN, 100 + 1, "\n");

    preg_match("/([a-zA-Z]+)'s ([a-z]+) is (?:an |a )?([a-zA-Z ]+)/", str_replace("\"", "", $cyborgReport), $matches);

    [, $name, $attribute, $type] = $matches;

    //We have already eliminated this cyborg
    if(!isset($cyborgs[$name])) continue;

    //Making sure the catchphrase contains the word
    if($attribute == "catchphrase" && isset($info["word"]) && preg_match("/\b" . $info["word"] . "\b/", $type, $match) == 0) {
        unset($cyborgs[$name]);
    } //Making sure the attribute is the same
    elseif(isset($info[$attribute]) && $type != $info[$attribute]) {
        unset($cyborgs[$name]);
    } 
}

if(count($cyborgs) == 0) echo "MISSING" . PHP_EOL;
elseif(count($cyborgs) > 1) echo "INDETERMINATE" . PHP_EOL;
else echo array_key_first($cyborgs) . PHP_EOL;
?>
