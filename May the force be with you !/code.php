<?php

const CONSONANTS = ["b", "c", "d", "f", "g", "h", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "v", "w", "x", "y", "z"];
const VOWELS = ["a", "e", "i", "o", "u"];

$hashedPassword = stream_get_line(STDIN, 32 + 1, "\n");

foreach(CONSONANTS as $consonant1) {
    foreach(VOWELS as $vowel) {
        foreach(CONSONANTS as $consonant2) {
            foreach(range(0, 99) as $number) {
                $password = ucfirst($consonant1) . $vowel . $consonant2 . sprintf("%02d", $number) . "*";

                if(md5($password) == $hashedPassword) exit($password);
            }
        }
    }
}

echo "PASSWORD_CHANGED" . PHP_EOL;
