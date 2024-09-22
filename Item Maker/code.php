<?php

const CORNERS = ["Common" => "####", "Rare" => "/\\\\/", "Epic" => "/\\\\/", "Legendary" => "XXXX"];
const FRAMES = [
    "Common" => ["#", "#", "#"], 
    "Rare" => ["#", "#", "#"], 
    "Epic" => ["-", "_", "|"],
    "Legendary" => ["-", "_", "|"],
];

//If the number of added space is odd we want the extra one on the left, STR_PAD_BOTH would add it on the right
function pad(string $s, int $size): string {
    $nbr = ($size - strlen($s)) / 2;
    return str_repeat(" ", ceil($nbr)) . $s . str_repeat(" ", floor($nbr));
}

$data = explode(",", trim(fgets(STDIN)));
$count = count($data);
$data[0] = "-" . $data[0] . "-";
$size = max(array_map(function($line) {
    return strlen($line);
}, $data));

error_log("$size");

$art[] = CORNERS[$data[1]][0] . str_repeat(FRAMES[$data[1]][0], $size + 2) . CORNERS[$data[1]][1];

foreach($data as $i => $s) {
    $art[] = FRAMES[$data[1]][2] . " " . ($i < 2 ? pad($s, $size) : str_pad(str_replace(":", " ", $s), $size, " ", STR_PAD_RIGHT)) . " " . FRAMES[$data[1]][2]; 
}

$art[] = CORNERS[$data[1]][2] . str_repeat(FRAMES[$data[1]][1], $size + 2) . CORNERS[$data[1]][3];

if($data[1] == "Legendary") {
    $art[1][0] = '[';
    $art[1][-1] = ']';

    $center = ($size >> 1) + 2;

    if($size & 1) {
        $art[0][$center] = '_';
        $art[0][$center - 1] = '\\';
        $art[0][$center + 1] = '/';
    } else {
        $art[0][$center] = $art[0][$center - 1] = '_';
        $art[0][$center - 2] = '\\';
        $art[0][$center + 1] = '/';
    }
}

echo implode(PHP_EOL, $art);
