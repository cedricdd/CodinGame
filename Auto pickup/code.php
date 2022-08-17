<?php

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%s", $packet);

$i = 0;
while($i < $n) {
    $instruction = substr($packet, $i, 3);
    $length = bindec(substr($packet, $i + 3, 4));
    $info = substr($packet, $i + 7, $length);

    //We have found the right ID
    if($instruction == "101") echo "001" . str_pad(decbin(strlen($info)), 4, "0", STR_PAD_LEFT ) . $info;

    $i += 7 + $length; //check next packet
}
?>
