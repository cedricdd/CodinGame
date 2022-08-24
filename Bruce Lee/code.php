<?php

$ENCRYPT = stream_get_line(STDIN, 4095 + 1, "\n");
$binary = "";

//Input is not valid
if(strlen(preg_replace("/0{1,2}\s0+(?:$|\s)/", "", $ENCRYPT)) != 0) die("INVALID");

//Get all the unary
preg_match_all("/0+ 0+/", $ENCRYPT, $matches);

foreach($matches[0] as $match) {
    [$left, $right] = explode(" ", $match);

    if($left === "0") $binary .= str_replace("0", "1", $right);
    else $binary .= $right;
}

if(strlen($binary) % 7 != 0) die("INVALID"); //Binary needs to be a multiple of 7, each characters needs to be use 7 bits

//Decode the message
foreach(str_split($binary, 7) as $character) {
    echo chr(bindec($character));
}
?>
