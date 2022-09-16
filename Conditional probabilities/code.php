<?php

$P = [
    "A" => null,
    "A AND B" => null,
    "A AND NOT B" => null,
    "A GIVEN B" => null,
    "A GIVEN NOT B" => null,
    "B" => null,
    "B GIVEN A" => null,
    "B GIVEN NOT A" => null,
    "NOT A" => null,
    "NOT A AND B" => null,
    "NOT A AND NOT B" => null,
    "NOT A GIVEN B" => null,
    "NOT A GIVEN NOT B" => null,
    "NOT B" => null,
    "NOT B GIVEN A" => null,
    "NOT B GIVEN NOT A" => null,
];

function GCD(int $a, int $b): int {
    while ($a != $b) {
        if ($a > $b) {
            $a -= $b;
        } else {
            $b -= $a;
        }
    }

    return $a;
}

function LCM(int $a, int $b): int {
    return $a * $b / GCD($a, $b);
}

function simplify(int $a, int $b): array {
    //Probability is < 0 or > 1
    if(($a / $b) < 0 || ($a / $b) > 1) die("IMPOSSIBLE");

    $gcd = GCD($a, $b);

    return [$a / $gcd, $b / $gcd];
}

function subFraction(array $a, array $b): array {
    $divisor = LCM($a[1], $b[1]);
    $dividend = ($a[0] * ($divisor / $a[1])) - ($b[0] * ($divisor / $b[1]));

    return simplify($dividend, $divisor);
}

function addFraction(array $a, array $b): array {
    $divisor = LCM($a[1], $b[1]);
    $dividend = ($a[0] * ($divisor / $a[1])) + ($b[0] * ($divisor / $b[1]));

    return simplify($dividend, $divisor);
}

function divFraction(array $a, array $b): array {
    return simplify($a[0] * $b[1], $a[1] * $b[0]);
}

function mulFraction(array $a, array $b): array {
    return simplify($a[0] * $b[0], $a[1] * $b[1]);
}

for($i = 0; $i < 3; ++$i) {
    preg_match("/([A-Z ]+) = ([0-9]+)\/([0-9]+)/", trim(fgets(STDIN)), $matches);
    $P[$matches[1]] = [$matches[2], $matches[3]];
}

//Until we can't find anymore values
do {
    $found = count(array_filter($P));

    foreach($P as $name => $values) {
        if($values != null) continue; //We already know this value

        switch($name) {
            case "A":
                //A = 1 - NOT A
                if($P["NOT A"] != null) $P[$name] = subFraction([1, 1], $P["NOT A"]);
                //A = A AND B / B GIVEN A
                elseif($P["A AND B"] != null && $P["B GIVEN A"] != null) $P[$name] = divFraction($P["A AND B"], $P["B GIVEN A"]);
                //A = A AND B + A AND NOT B
                elseif($P["A AND B"] != null && $P["A AND NOT B"] != null) $P[$name] = addFraction($P["A AND B"], $P["A AND NOT B"]);
                //A = A AND NOT B / NOT B GIVEN A
                elseif($P["A AND NOT B"] != null && $P["NOT B GIVEN A"] != null) $P[$name] = divFraction($P["A AND NOT B"], $P["NOT B GIVEN A"]);
                break;
            case "A AND B":
                //A AND B = A - A AND NOT B
                if($P["A AND NOT B"] != null && $P["A"] != null) $P[$name] = subFraction($P["A"], $P["A AND NOT B"]);
                //A AND B = B * A GIVEN B
                elseif($P["B"] != null && $P["A GIVEN B"] != null) $P[$name] = mulFraction($P["B"], $P["A GIVEN B"]);
                //A AND B = A * B GIVEN A
                elseif($P["A"] != null && $P["B GIVEN A"] != null) $P[$name] = mulFraction($P["A"], $P["B GIVEN A"]);
                //A AND B = B - NOT A AND B
                elseif($P["B"] != null && $P["NOT A AND B"] != null) $P[$name] = subFraction($P["B"], $P["NOT A AND B"]);
                break;
            case "A AND NOT B":
                //A AND NOT B = A - A AND B
                if($P["A AND B"] != null && $P["A"] != null) $P[$name] = subFraction($P["A"], $P["A AND B"]);
                //A AND NOT B = A GIVEN NOT B * NOT B
                elseif($P["A GIVEN NOT B"] != null && $P["NOT B"] != null) $P[$name] = mulFraction($P["A GIVEN NOT B"], $P["NOT B"]);
                //A AND NOT B = NOT B GIVEN A * A
                elseif($P["NOT B GIVEN A"] != null && $P["A"] != null) $P[$name] = mulFraction($P["NOT B GIVEN A"], $P["A"]);
                break;
            case "A GIVEN B":
                //A GIVEN B = "A AND B / B
                if($P["B"] != null && $P["A AND B"] != null) $P[$name] = divFraction($P["A AND B"], $P["B"]);
                //A GIVEN B = 1 - NOT A GIVEN B
                elseif($P["NOT A GIVEN B"] != null) $P[$name] = subFraction([1, 1], $P["NOT A GIVEN B"]);
                break;
            case "A GIVEN NOT B":
                //A GIVEN NOT B = A AND NOT B / NOT B
                if($P["A AND NOT B"] != null && $P["NOT B"] != null) $P[$name] = divFraction($P["A AND NOT B"], $P["NOT B"]);
                //A GIVEN NOT B = 1 - NOT A GIVEN NOT B
                elseif($P["NOT A GIVEN NOT B"] != null) $P[$name] = subFraction([1, 1], $P["NOT A GIVEN NOT B"]);
                break;
            case "B":
                //B = 1 - NOT B
                if($P["NOT B"] != null) $P[$name] = subFraction([1, 1], $P["NOT B"]);
                //B = A AND B / A GIVEN B
                elseif($P["A AND B"] != null && $P["A GIVEN B"] != null) $P[$name] = divFraction($P["A AND B"], $P["A GIVEN B"]);
                //B = A AND B + NOT A AND B
                elseif($P["A AND B"] != null && $P["NOT A AND B"] != null) $P[$name] = addFraction($P["A AND B"], $P["NOT A AND B"]);
                break;
            case "B GIVEN A":
                //B GIVEN A = A AND B / A
                if($P["A"] != null && $P["A AND B"] != null) $P[$name] = divFraction($P["A AND B"], $P["A"]);
                //B GIVEN A = 1 - NOT B GIVEN A
                elseif($P["NOT B GIVEN A"] != null) $P[$name] = subFraction([1, 1], $P["NOT B GIVEN A"]);
                break;
            case "B GIVEN NOT A":
                //B GIVEN NOT A = 1 - NOT B GIVEN NOT A
                if($P["NOT B GIVEN NOT A"] != null) $P[$name] = subFraction([1, 1], $P["NOT B GIVEN NOT A"]);
                //B GIVEN NOT A = NOT A AND B / NOT A
                elseif($P["NOT A AND B"] != null && $P["NOT A"] != null) $P[$name] = divFraction($P["NOT A AND B"], $P["NOT A"]);
                break;
            case "NOT A":
                //NOT A = 1 - A
                if($P["A"] != null) $P[$name] = subFraction([1, 1], $P["A"]);
                //NOT A = NOT A AND NOT B + NOT A AND B
                elseif($P["NOT A AND NOT B"] != null && $P["NOT A AND B"] != null) $P[$name] = addFraction($P["NOT A AND NOT B"], $P["NOT A AND B"]);
                //NOT = NOT A AND B / B GIVEN NOT A
                elseif($P["NOT A AND B"] != null && $P["B GIVEN NOT A"] != null) $P[$name] = divFraction($P["NOT A AND B"], $P["B GIVEN NOT A"]);
                break;
            case "NOT A AND B":
                //NOT A AND B = B - A AND B
                if($P["B"] != null && $P["A AND B"] != null) $P[$name] = subFraction($P["B"], $P["A AND B"]);
                //NOT A AND B = B GIVEN NOT A * NOT A
                elseif($P["B GIVEN NOT A"] != null && $P["NOT A"] != null) $P[$name] = mulFraction($P["B GIVEN NOT A"], $P["NOT A"]);
                //NOT A AND B = NOT A - NOT A AND NOT B
                elseif($P["NOT A"] != null && $P["NOT A AND NOT B"] != null) $P[$name] = subFraction($P["NOT A"], $P["NOT A AND NOT B"]);
                break;
            case "NOT A AND NOT B":
                //NOT A AND NOT B = NOT A - NOT A AND B
                if($P["NOT A"] != null && $P["NOT A AND B"] != null) $P[$name] = subFraction($P["NOT A"], $P["NOT A AND B"]);
                break;
            case "NOT A GIVEN B":
                //NOT A GIVEN B = 1 - A GIVEN B
                if($P["A GIVEN B"] != null) $P[$name] = subFraction([1, 1], $P["A GIVEN B"]);
                break;
            case "NOT A GIVEN NOT B":
                //NOT A GIVEN NOT B = 1 - A GIVEN NOT B
                if($P["A GIVEN NOT B"] != null) $P[$name] = subFraction([1, 1], $P["A GIVEN NOT B"]);
                break;
            case "NOT B":
                //NOT B = 1 - B
                if($P["B"] != null) $P[$name] = subFraction([1, 1], $P["B"]);
                //NOT B = A AND NOT B / A GIVEN NOT B
                elseif($P["A AND NOT B"] != null && $P["A GIVEN NOT B"] != null) $P[$name] = divFraction($P["A AND NOT B"], $P["A GIVEN NOT B"]);
                break;
            case "NOT B GIVEN A":
                //NOT B GIVEN A = 1 - B GIVEN A
                if($P["B GIVEN A"] != null) $P[$name] = subFraction([1, 1], $P["B GIVEN A"]);
                //NOT B GIVEN A = A AND NOT B / A
                elseif($P["A"] != null && $P["A AND NOT B"] != null) $P[$name] = divFraction($P["A AND NOT B"], $P["A"]);
                break;
            case "NOT B GIVEN NOT A":
                //NOT B GIVEN NOT A = 1 - B GIVEN NOT A
                if($P["B GIVEN NOT A"] != null) $P[$name] = subFraction([1, 1], $P["B GIVEN NOT A"]);
                break;
        }
    }
} while($found != count(array_filter($P)));

foreach(array_filter($P) as $name => [$a, $b]) {
    echo "$name = $a/$b" . PHP_EOL;
}

?>
