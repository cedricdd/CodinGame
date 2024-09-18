<?php

//We are encoding
function encode(int $w, int $h, string $input): string {
    if(empty($input)) return ""; //Nothing to do

    $total = strlen($input);
    $counts = count_chars($input, 1);

    if(($counts[35] ?? 0) == $total) return '1'; //Area is fully composed of black pixels
    if(($counts[46] ?? 0) == $total) return '0'; //Area is fully composed of white pixels

    $areas = [0 => "", 1 => "", 2 => "", 3 => ""];
    $bx = ceil($w / 2);
    $by = ceil($h / 2);

    //Generate the 4 areas
    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            $areas[($y >= $by ? 2 : 0) + ($x >= $bx ? 1 : 0)] .= $input[$y * $w + $x];
        }
    }

    //The encoding is the concatenation of the 4 quarters
    return "+" . encode($bx, $by, $areas[0]) . encode($w - $bx, $by, $areas[1]) . encode($bx, $h - $by, $areas[2]) . encode($w - $bx, $h - $by, $areas[3]);
}

function decode(int $w, int $h, int $index, string &$input): array {

    //Generate an area full composed of black pixels
    if($input[$index] == "1") return [$index + 1, array_fill(0, $h, str_repeat("#", $w))];
    //Generate an area full composed of white pixels
    if($input[$index] == "0") return [$index + 1, array_fill(0, $h, str_repeat(".", $w))];

    $bx = ceil($w / 2);
    $by = ceil($h / 2);
    ++$index; //We have a '+', skipping it

    //Top-Left
    [$index, $result] = decode($bx, $by, $index, $input);

    //Top-Right
    if($w > 1) {
        [$index, $result2] = decode($w - $bx, $by, $index, $input);

        //We need to concatenate the results
        foreach($result2 as $y => $line) $result[$y] .= $line;
    }

    //Bottom-Left
    if($h > 1) {
        [$index, $result2] = decode($bx, $h - $by, $index, $input);

        //We need to merge the results
        $result = array_merge($result, $result2);
    }

    //Bottom-Right
    if($w > 1 && $h > 1) {
        [$index, $result2] = decode($w - $bx, $h - $by, $index, $input);

        //We need to concatenate the results
        foreach($result2 as $y => $line) $result[$y + $by] .= $line;
    }

    return [$index, $result];
}

fscanf(STDIN, "%s %d %d", $c, $w, $h);
fscanf(STDIN, "%d", $ln);

$input = "";

for ($i = 0; $i < $ln; $i++) {
    $input .= trim(fgets(STDIN));
}

if($c == 'B') {
    $encoded = encode($w, $h, $input);

    echo "C $w $h" . PHP_EOL . strval(ceil(strlen($encoded) / 50)) . PHP_EOL . implode(PHP_EOL, str_split($encoded, 50));
} else {
    [, $decoded] = decode($w, $h, 0, $input);

    echo "B $w $h" . PHP_EOL . count($decoded) . PHP_EOL . implode(PHP_EOL, $decoded);
}
