<?php

function searchContradiction(string $letter, string $reference): bool {
    global $inequalities;

    if($letter == $reference) return true;

    $result = false;

    foreach($inequalities[$letter] ?? [] as $letter2) $result |= searchContradiction($letter2, $reference);

    return $result;
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    [$a, $b] = explode(" > ", trim(fgets(STDIN)));

    if(searchContradiction($b, $a)) exit("contradiction");

    $inequalities[$a][] = $b;
}

echo "consistent" . PHP_EOL;
