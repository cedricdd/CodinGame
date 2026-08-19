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
        $result .= ctype_upper($word1[$i] ?? $word1[$i - 1]) ? strtoupper($word2[$i]) : $word2[$i];
    }

    return $result;
}

fscanf(STDIN, "%d", $N);
for ($lines = 0; $lines < $N; $lines++) {
    $line = stream_get_line(STDIN, 500 + 1, "\n");

    preg_match("/^(\".+\")*(.+)$/", $line, $match);

    [, $quote, $speaker] = $match;

    if(preg_match("/.*hagrid.*/i", $speaker)) {
        preg_match_all('/[a-zA-Z\'\-]+/', $quote, $words);

        foreach($words[0] as $i => $word) {
            if(preg_match("/[\-\']/", $word)) continue; //We should not modified words that contains an apostrophe (') or a hyphen (-)

            $updated = $word;
            $len = strlen($word);

            //Check the 4 words
            if (($replacement = DICT[strtolower($updated)] ?? null) !== null) {
                $updated = replace($updated, $replacement);
            }

            if($len > 2) {
                //Check first & last letter
                $startingLetters = ['h' => true];
                $endingLetters = ['f' => true, 't' => true, 'd' => true, 'g' => true];

                //First letter
                if(isset($startingLetters[strtolower($updated[0])])) $updated[0] = "'";
                //Last letter
                if(isset($endingLetters[strtolower($updated[-1])])) $updated[-1] = "'";
            }

            $quote = preg_replace("/(?<=[^a-zA-Z\'\-])$word(?=[^a-zA-Z\'\-])/", $updated, $quote);
        }
    }

    echo $quote . $speaker . PHP_EOL;
}
