<?php

function updateGrid(array $grid, string $encoded, string $decoded): array {
    //Remove any punctuations, spaces & Q
    $encoded = preg_replace("/[^A-PR-Z]/", "", strtoupper($encoded));
    $decoded = preg_replace("/[^a-pr-z*]/", "", strtolower($decoded));

    //Check each pair of letters
    for($i = 0; $i < strlen($encoded) - 1; $i += 2) {
        if($decoded[$i] == '*' || $decoded[$i + 1] == '*') continue;

        //Find the letter in the top left
        for($y = 0; $y < 5; ++$y) {
            if(($x = array_search($decoded[$i], $grid["keys"][$y])) !== false) {
                [$x1, $y1] = [$x, $y];
                break;
            }
        }

        //Find the letter in the bottom right
        for($y = 6; $y < 11; ++$y) {
            if(($x = array_search($decoded[$i + 1], $grid["keys"][$y])) !== false) {
                [$x2, $y2] = [$x, $y];
                break;
            }
        }

        //If the letter is already set and doesn't match, one of the word we used wasn't the right one
        if($grid["keys"][$y1][$x2] != '.' && $grid["keys"][$y1][$x2] != $encoded[$i]) return [];
        else {
            $grid["keys"][$y1][$x2] = $encoded[$i];

            unset($grid["TR"][$encoded[$i]]);
        }

        //If the letter is already set and doesn't match, one of the word we used wasn't the right one
        if($grid["keys"][$y2][$x1] != '.' && $grid["keys"][$y2][$x1] != $encoded[$i + 1]) return [];
        else {
            $grid["keys"][$y2][$x1] = $encoded[$i + 1];

            unset($grid["BL"][$encoded[$i + 1]]);
        }

        //We are only missing one letter, we can set it
        if(count($grid["TR"]) == 1) {
            $lastLetter = array_key_first($grid["TR"]);
            unset($grid["TR"][$lastLetter]);

            for($y = 0; $y < 5; ++$y) {
                if(($x = array_search('.', $grid["keys"][$y])) !== false) {
                    $grid["keys"][$y][$x] = $lastLetter;
                    break;
                }
            }
        }

        //We are only missing one letter, we can set it
        if(count($grid["BL"]) == 1) {
            $lastLetter = array_key_first($grid["BL"]);
            unset($grid["BL"][$lastLetter]);

            for($y = 6; $y < 11; ++$y) {
                if(($x = array_search('.', $grid["keys"][$y])) !== false) {
                    $grid["keys"][$y][$x] = $lastLetter;
                    break;
                }
            }
        }
    }

    return $grid;
}

function decrypt(array $grid, string $a, string $b): array {
    [$a, $b] = array_map("ucfirst", [$a, $b]);

    //Find the letter in the top right
    for($y = 0; $y < 5; ++$y) {
        if(($x = array_search($a, $grid["keys"][$y])) !== false) {
            [$x1, $y1] = [$x, $y];
            break;
        }
    }

    //Find the letter in the bottom left
    for($y = 6; $y < 11; ++$y) {
        if(($x = array_search($b, $grid["keys"][$y])) !== false) {
            [$x2, $y2] = [$x, $y];
            break;
        }
    }

    //We can decode
    if(isset($x1) && isset($x2)) return [$grid["keys"][$y1][$x2], $grid["keys"][$y2][$x1]];
    else return [null, null];
}

function solve(array $grid, string $decodedMessage) {
    global $message, $words;

    //Decrypt the message with the current grid
    $indexPrev = null;

    for($i = 0; $i < strlen($message); ++$i) {
        if(ctype_alpha($message[$i]) && strcasecmp($message[$i], 'Q') != 0) {
            if($indexPrev === null) $indexPrev = $i; //This is the first letter of the pair
            else {
                //Try to decrypt the pair
                [$r1, $r2] = decrypt($grid, $message[$indexPrev], $message[$i]);
                
                if($r1 !== null && $r2 !== null) {
                    $decodedMessage[$indexPrev] = $r1;
                    $decodedMessage[$i] = $r2;
                } 

                $indexPrev = null;
            }
        }
    }

    //We don't have an even number of letters, last one isn't encoded
    if($indexPrev !== null) $decodedMessage[$indexPrev] = $message[$indexPrev];

    if(strpos($decodedMessage, '*') === false) {
        //Apply the proper case on decoded message
        for($i = 0; $i < strlen($message); ++$i) {
            //We need to switch to uppercase
            if(ctype_alpha($message[$i]) && ord($message[$i] )< 97) $decodedMessage[$i] = ucfirst($decodedMessage[$i]);
        }

        echo $decodedMessage . PHP_EOL;
        echo implode("\n", array_map(function($line) {
            return implode(" ", $line);
        }, $grid["keys"])) . PHP_EOL;

        exit();
    }

    $listWords = preg_split("/[^a-zA-Z]/", $message, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_OFFSET_CAPTURE);

    //error_log(var_export($listWords, true));

    foreach($listWords as [$word, $start]) {
        $length = strlen($word);
        $decodedWord = substr($decodedMessage, $start, $length);

        //This word is already fully decoded
        if(strpos($decodedWord, '*') === false) continue;

        foreach(($words[$length] ?? []) as $possibleWord) {
            if(preg_match("/" . str_replace('*', '.', $decodedWord) . "/", $possibleWord)) {
                $decodedMessageWithWord = substr_replace($decodedMessage, $possibleWord, $start, $length);

                $updatedGrid = updateGrid($grid, $message, $decodedMessageWithWord);

                //Invalid grid, one of word used was not right
                if(count($updatedGrid) == 0) continue;

                solve($updatedGrid, $decodedMessageWithWord);
            }
        }
    }
}

$ciphertext = trim(fgets(STDIN));
$plaintext = trim(fgets(STDIN));
$message = trim(fgets(STDIN));
fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    $word = strtolower(trim(fgets(STDIN)));
    $words[strlen($word)][] = $word;
}

$alphabet = array_flip(range('A', 'Z'));
unset($alphabet['Q']);

$grid = [
    "keys" => [
        ['a', 'b', 'c', 'd', 'e', ' ', '.', '.', '.', '.', '.'],
        ['f', 'g', 'h', 'i', 'j', ' ',  '.', '.', '.', '.', '.'],
        ['k', 'l', 'm', 'n', 'o', ' ',  '.', '.', '.', '.', '.'],
        ['p', 'r', 's', 't', 'u', ' ',  '.', '.', '.', '.', '.'],
        ['v', 'w', 'x', 'y', 'z', ' ',  '.', '.', '.', '.', '.'],
        [],
        ['.', '.', '.', '.', '.', ' ',  'a', 'b', 'c', 'd', 'e'],
        ['.', '.', '.', '.', '.', ' ',  'f', 'g', 'h', 'i', 'j'],
        ['.', '.', '.', '.', '.', ' ',  'k', 'l', 'm', 'n', 'o'],
        ['.', '.', '.', '.', '.', ' ',  'p', 'r', 's', 't', 'u'],
        ['.', '.', '.', '.', '.', ' ',  'v', 'w', 'x', 'y', 'z'],
    ], 
    "TR" => $alphabet,
    "BL" => $alphabet,
];

$grid = updateGrid($grid, $ciphertext, $plaintext); //We start by using the ciphertext & plaintext to populate the grid

//Every letter except 'Q' is encoded
$decodedMessage = preg_replace("/(?!q)[a-z]/", "*", strtolower($message));

solve($grid, $decodedMessage, []);
