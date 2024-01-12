<?php

function analyze(array $matches): array {
    $info = [];

    foreach($matches[0] as $match) {
        if(ctype_digit($match)) $type = "number";
        elseif(ctype_alpha($match)) $type = "letter";
        else $type = "punctuation";

        $info[] = [$match, $type];
    }

    return [count($matches[0]), $info];
}

$letterCase = trim(fgets(STDIN));
$letterFuzz = trim(fgets(STDIN));
$numberFuzz = trim(fgets(STDIN));
$otherFuzz = trim(fgets(STDIN));
$template = trim(fgets(STDIN));

preg_match_all("/([0-9]+|.)/", $template, $templateMatches);

[$countTemplate, $templateMatches] = analyze($templateMatches);

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $candidate = trim(fgets(STDIN));

    preg_match_all("/([0-9]+|.)/", $candidate, $candidateMatches);

    [$countCandidate, $candidateMatches] = analyze($candidateMatches);

    if($countTemplate != $countCandidate) {
        echo "false" . PHP_EOL;
        continue;
    }

    foreach($templateMatches as $index => $match) {
        //error_log("comparing " . $templateMatches[$index][0] . " && " . $candidateMatches[$index][0]);

        //Wrong type
        if($templateMatches[$index][1] != $candidateMatches[$index][1]) {
            echo "false" . PHP_EOL;
            continue 2;
        }

        //It's a letter
        if($templateMatches[$index][1] == "letter") {
            //letterCase
            if($letterCase == "true" && ctype_upper($templateMatches[$index][0]) != ctype_upper($candidateMatches[$index][0])) {
                echo "false" . PHP_EOL;
                continue 2; 
            }

            //letterFuzz
            if(abs(ord(strtolower($templateMatches[$index][0])) - ord(strtolower($candidateMatches[$index][0]))) > $letterFuzz) {
                echo "false" . PHP_EOL;

                error_log("here");

                continue 2; 
            }
        }
        //It's a number
        elseif($templateMatches[$index][1] == "number") {
            //numberFuzz
            if(abs(intval($templateMatches[$index][0]) - intval($candidateMatches[$index][0])) > $numberFuzz) {
                echo "false" . PHP_EOL;
                continue 2; 
            }
        } 
        //It's a punctuation
        elseif($otherFuzz == "true" && $templateMatches[$index][0] != $candidateMatches[$index][0]) {
            echo "false" . PHP_EOL;
            continue 2; 
        }
    }

    echo "true" . PHP_EOL;
}
