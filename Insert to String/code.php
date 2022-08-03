<?php

$string = explode('\n', stream_get_line(STDIN, 256 + 1, "\n"));

fscanf(STDIN, "%d", $changeCount);
for ($i = 0; $i < $changeCount; $i++) {
    [$line, $pos, $chars] = explode("|", stream_get_line(STDIN, 256 + 1, "\n"));

    $changes[$line][$pos] = $chars;
}

//Apply the changes on each lines
foreach($changes as $line => $list) {
    //To avoid conflict we do them from left to right
    ksort($list);

    $m = 0; //Keep track of how many characters have alreacdy insterted
    foreach($list as $pos => $chars) {
        $string[$line] = substr($string[$line], 0, $pos + $m) . $chars . substr($string[$line], $pos + $m);
        $m += strlen($chars);
    }

    //Split line by \n and output it
    echo implode("\n", explode('\n', $string[$line])) . "\n";
}
?>
