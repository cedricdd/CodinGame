<?php

$text = stream_get_line(STDIN, 500 + 1, "\n");

//Step 1
$text = strtr($text, ["??=" => "#", "??/" => "\\", "??'" => "^", "??(" => "[", "??)" => "]", "??!" => "|", "??-" => "~"]);

//Step 2
for($i = 0; $i < strlen($text); ++$i) {
    if($text[$i] == "\\") {
        if($text[$i + 1] == "x") $text = substr_replace($text, mb_chr(hexdec(substr($text, $i + 2, 2))), $i, 4);
        elseif($text[$i + 1] == "u") $text = substr_replace($text, mb_chr(hexdec(substr($text, $i + 2, 4))), $i, 6);
        elseif($text[$i + 1] == "U") $text = substr_replace($text, mb_chr(hexdec(substr($text, $i + 2, 8))), $i, 10);
        else $text = substr_replace($text, "", $i, 1);
    }
}

//Step 3
preg_match_all("/\&\#(.+?)\;/", $text, $matches);

foreach($matches[1] as $i => $match) {
    $text = str_replace($matches[0][$i], mb_chr($match), $text);
}

$text = strtr($text, ["&amp;" => "&", "&lt;" => "<", "&gt;" => ">", "&bsol;" => "\\"]);

echo $text . PHP_EOL;
