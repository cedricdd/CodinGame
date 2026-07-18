<?php

const DICT = [
    'you' => 'yeh',
    'to'  => 'ter',
    'and' => "an'",
    'me'  => 'meh',
];

function replace(string $word1, string $word2): string {
    $result = "";

    $len = strlen($word2);

    for ($i = 0; $i < $len; ++$i) {
        $result .= ctype_upper($word1[$i] ?? '')
            ? strtoupper($word2[$i])
            : $word2[$i];
    }

    return $result;
}

fscanf(STDIN, "%d", $N);
for ($lines = 0; $lines < $N; $lines++) {
    $line = stream_get_line(STDIN, 500 + 1, "\n");

    preg_match("/^(\".+\")*(.+)$/", $line, $match);

    [, $quote, $speaker] = $match;

    if(preg_match("/.*hagrid.*/i", $speaker)) {
        preg_match_all('/\w+|[[:punct:]]/', $quote, $words);

        $quote = "";

        foreach($words[0] as $i => $word) {
            if(!ctype_alpha($word)) {
                $quote .= $word;
                continue;
            }

            $lower = strtolower($word);

            //Check the 4 words
            if (isset(DICT[$lower])) {
                $word = replace($word, DICT[$lower]);
            }

            //Check first & last letter
            $len = strlen($word);
            $startingLetters = ['h' => true];
            $endingLetters = ['f' => true, 't' => true, 'd' => true, 'g' => true];

            //First letter
            if(isset($startingLetters[strtolower($word[0])])) $word[0] = "'";
            //Last letter
            if(isset($endingLetters[strtolower($word[-1])])) $word[-1] = "'";

            $quote .= ($quote[-1] == "\"" ? "" : " ") . $word;
        }
    }

    echo $quote . $speaker . PHP_EOL;
}

