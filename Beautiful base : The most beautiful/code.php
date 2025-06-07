<?php

/**
 * If log⁡B(n)=klogB​(n)=k, then: B ** k = n ⇒ B = n ** 1/k
 */
function mostBeautifulBase(int $n) {
    if ($n <= 1) {
        return "NONE"; // No beautiful base for n <= 1
    }

    $max_k = floor(log($n, 2)); // Maximum exponent to try

    for ($k = $max_k; $k >= 2; $k--) {
        $approxBase = round(pow($n, 1.0 / $k)); //Make the value an integer

        // Try a few nearby values in case of rounding errors
        for ($b = max(2, $approxBase - 1); $b <= $approxBase + 1; $b++) {
            // Use BCMath or for big integers 
            $power = bcpow((string)$b, (string)$k);

            // If they match it means the value is an integer so we found the most beautiful base
            if ((string)$power === (string)$n) return $b; 
        }
    }

    return "NONE"; 
}

$n = trim(fgets(STDIN));

echo mostBeautifulBase($n) . PHP_EOL;
