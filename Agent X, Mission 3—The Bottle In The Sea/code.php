<?php

$message = stream_get_line(STDIN, 10000 + 1, "\n");
fscanf(STDIN, "%d", $keylength);
fscanf(STDIN, "%s", $word);

$index = 0;

foreach(preg_split("/[^a-zA-Z]/", $message, -1, PREG_SPLIT_NO_EMPTY) as $wordToCheck) {
    $length = strlen($wordToCheck);

    //This is potentially the word we know
    if($length == strlen($word)) {
        $wordToCheck = strtoupper($wordToCheck); //The word is upper case

        $keyInfo = [];

        for($i = 0; $i < $length; ++$i) {
            $diff = (ord($wordToCheck[$i]) - ord($word[$i]) + 26) % 26; //Calculate what would be shift at this position

            //The shift is incompatible with a previous one, this encrypted word can't be the one we know
            if(isset($keyInfo[($index + $i) % $keylength]) && $keyInfo[($index + $i)  % $keylength] != $diff) {
                $index += $length;

                continue 2;
            }

            $keyInfo[($index + $i) % $keylength] = $diff;
        }

        //We have found the key
        $key = "";
        for($i = 0; $i < $keylength; ++$i) $key .= chr($keyInfo[$i] + 65);

        echo $key . PHP_EOL;

        //Decrypt the message
        $index = 0;
        $decrypted = "";

        foreach(str_split(mb_substr($message, 0, 900)) as $c) {
            if(ctype_alpha($c)) {
                $hex = ord($c);

                //Lower case
                if($hex >= 97) $decrypted .= chr((($hex - 97 - $keyInfo[$index % $keylength]  + 26) % 26) + 97);
                //Upper case
                else $decrypted .= chr((($hex - 65 - $keyInfo[$index % $keylength]  + 26) % 26) + 65);

                
                ++$index;
            } else $decrypted .= $c;
        }

        echo $decrypted . PHP_EOL;
        exit();
    }

    $index += $length;
}
