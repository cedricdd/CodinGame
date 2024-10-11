<?php

// Function to check if a number is prime
function isPrime(int $num): bool {
    if ($num <= 1) return false;
    if ($num == 2) return true;
    if ($num % 2 == 0) return false; 

    $sqrtNum = sqrt($num);

    for ($i = 3; $i <= $sqrtNum; $i += 2) {
        if ($num % $i == 0) return false;
    }

    return true;
}


// Function to find the next pair of prime twins starting from X
function findNextPrimeTwins(int $x): int {
    // Start from the next odd number
    if ($x % 2 == 0) $x++;

    while (true) {
        if (isPrime($x) && isPrime($x + 2)) return $x + 1; // Found the twin primes

        $x += 2; // Move to the next odd number
    }
}

//Generate the alphabet with the key
function getAlphabet(int $key): array {
    $alphabet = [];
    $value = $key;

    foreach(range('A', 'Z') as $letter) {
        $alphabet[$letter] = strtoupper(dechex($key + $value));

        $value = findNextPrimeTwins($key + $value + 1);
    }

    return $alphabet;
}

$start = microtime(1);

$operation = trim(fgets(STDIN));
fscanf(STDIN, "%d", $key);
$message = trim(fgets(STDIN));
$alphabet = getAlphabet($key);

//We are encoding
if($operation == "ENCODE") {
    if(!preg_match("/^[A-Z ]+$/", $message)) echo "ERROR !!" . PHP_EOL;
    else {
        $alphabet[" "] = "";

        foreach(str_split($message) as $c) {
            $output[] = $alphabet[$c];
        }
    
        echo implode("G", $output) . PHP_EOL;
    }
} //We are decoding
else {
    //Check that all the characters are allowed and that we don't have a substring of G of odd length > 1
    if(!preg_match("/^[0-9A-G]+$/", $message) || preg_match("/(?<!G)(G{2})+G(?!G)/", $message)) echo "ERROR !!" . PHP_EOL;
    else {
        $alphabet = array_flip($alphabet) + [" " => " "];
        $letters = preg_split("/G/", str_replace("GG", "G G", $message), -1, PREG_SPLIT_NO_EMPTY);
    
        $decoded = implode("", array_map(function($letter) use ($alphabet) {
            return $alphabet[$letter];
        }, $letters));
    
        echo $decoded . PHP_EOL;
    }
}

error_log(microtime(1) - $start);
