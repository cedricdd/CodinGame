<?php

//Remove any character that's not a letter and convert all to lowercase
$text = preg_replace("/[^a-z]/", "", strtolower(stream_get_line(STDIN, 1000 + 1, "\n")));

fscanf(STDIN, "%d", $N);
for ($l = 0; $l < $N; $l++) {
    $words[] = str_split(stream_get_line(STDIN, 25 + 1, "\n"));
}

//Sort words by size so we can stop as soon as we find the first match
usort($words, function($a, $b) {
    return count($b) <=> count($a);
});

foreach($words as $letters) {
    array_walk($letters, function(&$letter) {
        $letter = "($letter)";
    });

    //Search the secret word with regex
    for($space = intdiv(strlen($text), count($letters)); $space >= 0; --$space) {
        if(preg_match("/" . implode(".{" . $space . "}", $letters) . "/", $text, $match, PREG_OFFSET_CAPTURE)) {

            $secret = $match[0][0];
    
            //Highlight the letters of the word
            for($i = 1; $i <= count($letters); ++$i) $secret[$match[$i][1] - $match[0][1]] = ucwords($match[$i][0]);
    
            die("$secret");
        }
    }
}
?>
