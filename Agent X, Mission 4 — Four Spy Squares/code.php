<?php

function buildGrid(array &$grid, string $encoded, string $decoded) {
    for($y = 0; $y < 5; ++$y) {
        if(($x = array_search($decoded[0], $grid[$y])) !== false) {
            [$x1, $y1] = [$x, $y];
            break;
        }
    }
    for($y = 6; $y < 11; ++$y) {
        if(($x = array_search($decoded[1], $grid[$y])) !== false) {
            [$x2, $y2] = [$x, $y];
            break;
        }
    }

    $grid[$y1][$x2] = $encoded[0];
    $grid[$y2][$x1] = $encoded[1];
}

function decrypt(array $grid, string $pair): string {
    [$a, $b] = str_split(strtoupper($pair));

    for($y = 0; $y < 5; ++$y) {
        if(($x = array_search($a, $grid[$y])) !== false) {
            [$x1, $y1] = [$x, $y];
            break;
        }
    }
    for($y = 6; $y < 11; ++$y) {
        if(($x = array_search($b, $grid[$y])) !== false) {
            [$x2, $y2] = [$x, $y];
            break;
        }
    }

    if(isset($x1) && isset($x2)) return $grid[$y1][$x2] . $grid[$y2][$x1];
    else return "..";
}

$ciphertext = stream_get_line(STDIN, 1024 + 1, "\n");
$plaintext = stream_get_line(STDIN, 1024 + 1, "\n");
$message = stream_get_line(STDIN, 1024 + 1, "\n");
fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    $word = strtolower(trim(fgets(STDIN)));
    $words[strlen($word)][] = $word;
}

$grid = [
    ['a', 'b', 'c', 'd', 'e', ' ', '.', '.', '.', '.', '.'],
    ['f', 'g', 'h', 'i', 'j', ' ',  '.', '.', '.', '.', '.'],
    ['k', 'l', 'm', 'n', 'o', ' ',  '.', '.', '.', '.', '.'],
    ['p', 'r', 's', 't', 'u', ' ',  '.', '.', '.', '.', '.'],
    ['v', 'w', 'x', 'y', 'z', ' ',  '.', 'C', '.', '.', '.'],
    [],
    ['.', '.', '.', '.', '.', ' ',  'a', 'b', 'c', 'd', 'e'],
    ['.', '.', '.', '.', '.', ' ',  'f', 'g', 'h', 'i', 'j'],
    ['.', '.', '.', '.', '.', ' ',  'k', 'l', 'm', 'n', 'o'],
    ['.', '.', '.', '.', '.', ' ',  'p', 'r', 's', 't', 'u'],
    ['.', '.', '.', '.', '.', ' ',  'v', 'w', 'x', 'y', 'z'],
];

//Remove any punctuations, spaces & Q
$ciphertext = preg_replace("/[^A-PR-Z]/", "", strtoupper($ciphertext));
$plaintext = preg_replace("/[^a-pr-z]/", "", strtolower($plaintext));

for($i = 0; $i < strlen($ciphertext); $i += 2) {
    buildGrid($grid, substr($ciphertext, $i, 2), substr($plaintext, $i, 2));
}

//error_log(var_export($grid, true));
$listWords = preg_split("/[^a-zA-Z]/", $message, -1, PREG_SPLIT_NO_EMPTY);


$addPrev = false;
$addAfter = false;

foreach($listWords as $i => $word) {
    $wordPair = $word;
    $length = strlen($word);

    if($addPrev) {
        $wordPair = $listWords[$i - 1][-1] . $wordPair;
    }
    if(strlen($wordPair) % 2 != 0 && $i != count($listWords) - 1) {
        $wordPair .= $listWords[$i + 1][0];
        $addAfter = true;
    }

    $pairDecryted = "";
    $wordDecrypted = "";

    foreach(str_split($wordPair, 2) as $pair) $pairDecryted .= decrypt($grid, $pair);

    error_log("working on $word -- $wordPair -- $pairDecryted");

    $wordDecrypted = $pairDecryted;
    if($addPrev) $wordDecrypted = substr($wordDecrypted, 1);
    if($addAfter) $wordDecrypted = substr($wordDecrypted, 0, -1);

    //Not fully decrypted
    if(($p = strpos($pairDecryted, '.')) !== false) {
        foreach($words[$length] as $possibleWord) {
            if(preg_match("/" . $wordDecrypted . "/i", $possibleWord)) {
                error_log("word is $possibleWord");

                $skip = 0;

                while($p = strpos($pairDecryted, '.', $skip)) {
                    buildGrid($grid, strtoupper(substr($wordPair, $p, 2)), substr($possibleWord, $p - ($addPrev ? 1 : 0), 2));
                    error_log($p . " " . strtoupper(substr($wordPair, $p, 2)) . " " . substr($possibleWord, $p - ($addPrev ? 1 : 0), 2)); 
                    $skip = $p + 2;
                }

                $wordDecrypted = $possibleWord;
                break;
            }
        }
    }

    for($i = 0; $i < $length; ++$i) {
        //We need to set the character to upper case
        if(ord($word[$i]) < 97) $wordDecrypted[$i] = ucfirst($wordDecrypted[$i]);
    }

    $wordsDecrypted[$word] = $wordDecrypted;

    $addPrev = $addAfter ? true : false;
    $addAfter = false;
}

error_log(var_export($wordsDecrypted, true));

echo strtr($message, $wordsDecrypted) . PHP_EOL;
echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $grid)) . PHP_EOL;
