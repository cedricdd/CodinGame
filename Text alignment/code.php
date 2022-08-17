<?php

$width = 0;
$alignment = stream_get_line(STDIN, 7 + 1, "\n");

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $text[] = stream_get_line(STDIN, 256 + 1, "\n");
    $width = max($width, strlen($text[$i]));
}

//Add pad on the left
if($alignment == "RIGHT") {
    foreach($text as &$line) {
        $line = str_pad($line, $width, " ", STR_PAD_LEFT);
    }
} //Add pad on both side  
elseif($alignment == "CENTER") {
    foreach($text as &$line) {
        $line = rtrim(str_pad($line, $width, " ", STR_PAD_BOTH));
    }
} //Add pad between words 
elseif($alignment == "JUSTIFY") {
    foreach($text as &$line) {
        $space = (($width - strlen($line)) / (str_word_count($line) - 1)); //The amount of space to add between 2 words
        $justify = "";
        $previous = 0;

        foreach(explode(" ", $line) as $i => $word) {
            if($i > 0) {
                $extraSpace = round($space * $i) - $previous; //The amound of space to add before this word
                $previous += $extraSpace;
                $justify .= str_repeat(" ", $extraSpace + 1) ;
            }

            $justify .= $word;
        }

        $line = $justify;
    }
}

echo implode("\n", $text) . PHP_EOL;
?>
