<?php

const FACTORS = [3, 7, 9, 0, 5, 8, 4, 2, 1, 6];

//Calculate the check digit
function getCheckDigit(array $digits): int {
    return array_sum(
        array_map(function($a, $b) { return $a * $b; }, $digits, FACTORS)
    ) % 11;
}

//Check the validity of a date
function validateDate($date) {
    $d = DateTime::createFromFormat("dmy", $date);
    return $d && $d->format("dmy") == $date;
}

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $number = trim(fgets(STDIN));

    //Check the syntax of the number
    if(preg_match("/^[1-9][0-9]{9}$/", $number, $match) == false) {
        echo "INVALID SYNTAX" . PHP_EOL;
        continue;
    }

    if(validateDate(substr($number, 4)) === false) {
        echo "INVALID DATE" . PHP_EOL;
        continue;
    }

    $checkDigit = getCheckDigit(str_split($number));

    //Valid number
    if($checkDigit == $number[3]) echo "OK" . PHP_EOL;
    //We have "to fix" the number
    else {
        //Keep increasing the identifier until the check digit is no longer 10
        while($checkDigit == 10) {
            $number = (substr($number, 0, 3) + 1) . substr($number, 3);
            $checkDigit = getCheckDigit(str_split($number));
        }
        
        $number[3] = $checkDigit;

        echo $number . PHP_EOL;
    }
}
?>
