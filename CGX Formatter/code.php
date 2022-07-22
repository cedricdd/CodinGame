<?php

$indent = 0;
$buffer = "";

function printText(string $text): void {
    global $indent;

    $text = trim($text);

    if(strlen($text) == 0) return; //Don't print empty array

    if($text[0] == ")") --$indent; //Increase indent value

    $text = preg_replace('/(\'[^\']*\')\s*=\s*(\'[^\']*\')/', '$1=$2', $text); //Remove spaces arround equal in 'xxx' = 'xxx'

    //Remove spaces in primitive type
    if(preg_match("/(\'[^\']+\')\s*=([a-z0-9 ;]+)/", $text, $matches)) {
        $text = $matches[1] . "=" . str_replace(' ', '', $matches[2]);
    }

    echo str_repeat(" ", $indent * 4) . $text . "\n"; //All formatted, print it

    if($text[0] == "(") ++$indent; //Decrease indent value
}

fscanf(STDIN, "%d", $N);

for ($i = 0; $i <= $N; $i++) {
    $line = stream_get_line(STDIN, 1000 + 1, "\n");

    preg_match_all("/\(|\);?|\'[^\']*\'\s*=?(?:\s*\'[^\']*\'|[a-z0-9 ]+)?;?|[a-z0-9 ]+;?/", $line, $matches);

    foreach($matches[0] as $match) {
        //We found something that needs to printed on his own line, print what's in buffer then the new part
        if(in_array($match[-1], ['(', ')', ';'])) {
            printText($buffer);
            printText($match);

            $buffer = "";
        } else $buffer .= $match; //Add it into buffer, info might be split on several lines
    }
}
printText($buffer); //Empty buffer
?>
