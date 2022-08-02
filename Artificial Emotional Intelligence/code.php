<?php

const adjList = [
    "b" => "adaptable", "c" => "adventurous", "d" => "affectionate", "f" => "courageous", "g" => "creative", "h" => "dependable", 
    "j" => "determined", "k" => "diplomatic", "l" => "giving", "m" => "gregarious", "n" => "hardworking", "p" => "helpful",  "q" => "hilarious", 
    "r" => "honest", "s" => "non-judgmental", "t" => "observant", "v" => "passionate", "w" => "sensible", "x" => "sensitive", "z" => "sincere"
];
const goodList = ["a" => "love", "e" => "forgiveness",   "i" => "friendship", "o" => "inspiration", "u" => "epic transformations", "y" => "wins"];
const badList = ["a" => "crime", "e"=> "disappointment", "i" => "disasters",  "o" => "illness",     "u" => "injury",               "y" => "investment loss"];

$name = stream_get_line(STDIN, 256 + 1, "\n");

preg_match_all("/[aeiouy]/", strtolower($name), $matches);
$vowels = $matches[0];

preg_match_all("/[bcdfghjklmnpqrstvwxz]/", strtolower($name), $matches);
$consonants = array_values(array_unique($matches[0]));

error_log(var_export($consonants , true));
error_log(var_export($vowels , true));

if(count($consonants) < 3 || count($vowels) < 2) echo "Hello $name.\n";
else {
    echo "It's so nice to meet you, my dear " . adjList[$consonants[0]] . " $name.\n";
    echo "I sense you are both " . adjList[$consonants[1]] . " and " . adjList[$consonants[2]] . ".\n";
    echo "May our future together have much more " . goodList[$vowels[0]] . " than " . badList[$vowels[1]] . ".\n";

}
?>
