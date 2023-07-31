<?php

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $input = trim(fgets(STDIN));

    preg_match("/\\$([0-9]+) = (.*)/", $input, $matches);

    //Save the price of each emojis, an emoji is 4 bytes 
    foreach(array_chunk(unpack('C*', $matches[2]), 4) as $emoji) $prices[implode('-', $emoji)] = $matches[1];
}

$worth = 0;

fscanf(STDIN, "%d", $gardenHeight);
for ($i = 0; $i < $gardenHeight; $i++) {
    //We remove everything that's not part of an emoji, spaces, weeds (punctuations), ...
    $cleaned = array_filter(unpack('C*', trim(fgets(STDIN))), function ($ascii) {
        return $ascii > 127;
    });

    foreach(array_chunk($cleaned, 4) as $emoji) {
        //Add the price or 0 if nobody wants to buy that emoji
        $worth += $prices[implode('-', $emoji)] ?? 0;
    }
}

echo "$" . number_format($worth, 0, ".", ",") . PHP_EOL;
