<?php

function getDirectinalVerctor(array $v1, array $v2): string {
    $vector["i"] = $v1["i"] - $v2["i"];
    $vector["j"] = $v1["j"] - $v2["j"];
    $vector["k"] = $v1["k"] - $v2["k"];

    $gcd = abs(GCD($vector["i"], GCD($vector["j"], $vector["k"])));

    $result = "";

    foreach($vector as $i => &$value) {
        if($value == 0) continue;

        $value /= $gcd;

        if($value > 0) {
            if($value == 1) $result .= "+" . $i;
            else $result .= "+" . $value . $i;
        } else {
            if($value == -1) $result .= "-" . $i;
            else $result .= $value . $i;
        }
    }

    return ltrim($result, "+");
}

function getDistance(array $v1, array $v2): float {
    return sqrt(pow($v2["i"] - $v1["i"], 2) + pow($v2["j"] - $v1["j"], 2) + pow($v2["k"] - $v1["k"], 2));
}

function GCD(int $a, int $b): int {
    return $b ? GCD($b, $a % $b) : $a;
}

//Extract the three value of the vector
function extractVector(string $input): array {
    $vector = ["i" => 0, "j" => 0, "k" => 0];

    $sign = "+";
    $value = "";

    for($i = 0; $i < strlen($input); ++$i) {
        switch($input[$i]) {
            case "+":
            case "-":
                $sign = $input[$i];
                break;
            case "i":
            case "j":
            case "k":
                $vector[$input[$i]] = intval($value ?: 1) * ($sign == "+" ? 1 : -1);
                $value = "";
                break;
            default:
                $value .= $input[$i];
        }
    }

    return $vector;
}


$ship = extractVector(trim(fgets(STDIN)));
$wormhole = extractVector(trim(fgets(STDIN)));

echo "Direction: " . getDirectinalVerctor($wormhole, $ship) . PHP_EOL;
echo "Distance: " . number_format(getDistance($wormhole, $ship), 2, ".", "") . PHP_EOL;
