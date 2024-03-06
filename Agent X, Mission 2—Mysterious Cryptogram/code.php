<?php

$alphabet = array_combine(range('A', 'Z'), array_fill(0, 26, 0));

$sentence = trim(fgets(STDIN));
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $word = trim(fgets(STDIN));

    $words[strlen($word)][] = $word;
}

//Get all the words we need to decrypt
foreach(preg_split("/\s|\,|\.|\?|\;|\:|\!/", $sentence, -1, PREG_SPLIT_NO_EMPTY) as $word) {
    if(ctype_digit($word)) continue; //It's just numbers, we continue

    $length = strlen($word);
    $candidates = $words[$length]; //Any words in the register with the same length is a candidate

    //We check if each possible candidate has the same letters distribution
    foreach($candidates as $id => $candidate) {
        $substitution = [];

        for($i = 0; $i < $length; ++$i) {
            //This candidate can't he the decrypted word
            if(isset($substitution[$word[$i]]) && $substitution[$word[$i]] != $candidate[$i]) {
                unset($candidates[$id]);

                continue 2;
            }

            $substitution[$word[$i]] = $candidate[$i];
        }
    }

    $wordsToDecrypt[$word] = $candidates;
}

while(count($wordsToDecrypt)) {
    foreach($wordsToDecrypt as $word => &$candidates) {
        $wordArray = array_map('strtoupper', str_split($word));
    
        foreach($candidates as $indexCandidate => $candidate) {
            for($i = 0; $i < strlen($candidate); ++$i) {
                //If we know how the letter would be encrypted, check that
                if(($encryption = array_search($candidate[$i], $alphabet, true)) !== false) {
                    //This candidate can't be the original word, mistmatch
                    if($encryption != $wordArray[$i]) {
                        unset($candidates[$indexCandidate]);

                        continue 2;
                    }
                }

                //If we know how the letter would be decrypted, check that
                if(($decryption = ($alphabet[$wordArray[$i]] ?? $wordArray[$i])) !== 0) {
                    //This candidate can't be the original word, mistmatch
                    if($decryption != $candidate[$i]) {
                        unset($candidates[$indexCandidate]);

                        continue 2;
                    }
                }
            }
        }
    
        //We know what the word is, there's only one candidate left
        if(count($candidates) == 1) {
            $candidate = array_pop($candidates);
            $decrypted = "";
    
            foreach($wordArray as $i => $letterEncrypted) {
                $letterDecrypted = $candidate[$i];
                $alphabet[$letterEncrypted] = $letterDecrypted;
    
                //Keep the case when decrypting
                $decrypted .= (ord($word[$i]) >= 97) ? strtolower($letterDecrypted) : $letterDecrypted;
            }
    
            $wordsDecrypted[$word] = $decrypted;

            unset($wordsToDecrypt[$word]);
        }
    }
}

$alphabet = array_flip(array_filter($alphabet));

//Decrypt & print the sentence
echo strtr($sentence, $wordsDecrypted) . PHP_EOL;

//Print the substitution table
foreach(range("A", "Z") as $letter) {
    if(!isset($alphabet[$letter])) echo "Na" . PHP_EOL;
    else echo $letter . " -> " . $alphabet[$letter] . PHP_EOL;
}
