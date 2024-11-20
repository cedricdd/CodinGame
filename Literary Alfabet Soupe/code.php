<?php

$languages = ["Danish", "English", "Estonian", "Finnish", "French", "German", "Irish", "Italian", "Portuguese", "Spanish", "Swedish", "Turkish", "Welsh"];

for ($i = 0; $i < 13; $i++) {
    $excerpt = stream_get_line(STDIN, 500 + 1, "\n");

    //Remove special characters
    $excerpt = preg_replace("/[!?\-\.\'\’\s\,\:\—\;\–]/", "", $excerpt);

    //Check if it can be each languages
    if(preg_match("/^((?=[a-zøæå])[^qz])+$/i", $excerpt)) $possibility[$i]["Danish"] = 1;
    if(preg_match("/^[a-z]+$/i", $excerpt)) $possibility[$i]["English"] = 1;
    if(preg_match("/^((?=[a-zšžõäöü])[^cfqwxy])+$/i", $excerpt)) $possibility[$i]["Estonian"] = 1;
    if(preg_match("/^((?=[a-zäö])[^bfqwx])+$/i", $excerpt)) $possibility[$i]["Finnish"] = 1;
    if(preg_match("/^[a-zçœéàèùëïüâêîôû]+$/i", $excerpt)) $possibility[$i]["French"] = 1;
    if(preg_match("/^[a-zßäöü]+$/i", $excerpt)) $possibility[$i]["German"] = 1;
    if(preg_match("/^((?=[a-záéíóúÍ])[^jkqvwxyz])+$/i", $excerpt)) $possibility[$i]["Irish"] = 1;
    if(preg_match("/^((?=[a-zéàèìòùÈ])[^kwxy])+$/i", $excerpt)) $possibility[$i]["Italian"] = 1;
    if(preg_match("/^((?=[a-zçãõáéíóúàâêôÉ])[^kw])+$/i", $excerpt)) $possibility[$i]["Portuguese"] = 1;
    if(preg_match("/^((?=[a-zñáéíóúü¿])[^kw])+$/i", $excerpt)) $possibility[$i]["Spanish"] = 1;
    if(preg_match("/^((?=[a-zåäö])[^qw])+$/i", $excerpt)) $possibility[$i]["Swedish"] = 1;
    if(preg_match("/^((?=[a-zçğşİıöüÇ])[^qwx])+$/i", $excerpt)) $possibility[$i]["Turkish"] = 1;
    if(preg_match("/^((?=[a-zŵŷâêîôû])[^jkqvxz])+$/i", $excerpt)) $possibility[$i]["Welsh"] = 1;
}

$output = array_fill(0, 13, "");

while($possibility) {

    foreach($languages as $languageID => $language) {

        $positions = [];
        
        //Get all the positions this language can go
        foreach($possibility as $index => $list) {
            if(isset($list[$language])) {
                //We are sure this language goes here, it's the only one left
                if(count($list) == 1) {
                    $positions = [$index => 1];
                    break;
                } else $positions[$index] = 1;
            }
        }

        //We have found the position of a language
        if(count($positions) == 1) {
            $position = array_key_first($positions);

            $output[$position] = $language;

            unset($possibility[$position]);
            unset($languages[$languageID]);
        }
    }   
}

echo implode(PHP_EOL, $output) . PHP_EOL;
