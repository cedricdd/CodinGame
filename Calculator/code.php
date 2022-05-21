<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/
function formatOutput($value) {
    if(intval($value) == $value) return $value;
    return rtrim(number_format($value, 3, ".", ""), '0');
}

$number = "";
$operation = [];
$pressedEntered = 0;

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $key = stream_get_line(STDIN, 2 + 1, "\n");

    error_log(var_export("key: " .$key, true));

    switch($key) {
        case '+':
        case '-':
        case 'x':
        case '/':
        case '=':
            //Two+ operations keys consecutively
            if(empty($number)) {
                $operation[1] = $key; //use the last operation entered
                echo formatOutput($operation[0]) . "\n";
                break;
            }

            //Normal operation or we press = again
            if(!$pressedEntered || $key == "=") {
                switch($operation[1] ?? "") {
                    case '+':
                        $result = $operation[0] + intval($number);
                        break;
                    case '-':
                        $result = $operation[0] - intval($number);
                        break;
                    case 'x':
                        $result = $operation[0] * intval($number);
                        break;
                    case '/':
                        $result = $operation[0] / intval($number);
                        break;
                    default:
                        $result = intval($number);
                }
            } //We start an operation after an =
            elseif($pressedEntered && $key != '=') {
                $pressedEntered = 0;
                $number = "";
            }
      
            echo formatOutput($result) . "\n";

            //Save with decimal part only if number is not an integer
            if(intval($result) != $result) $result = number_format($result, 3, ".", "");

            if($key != '=') {
                $operation = [$result, $key];
                $number = "";
            } else {
                $operation[0] = $result;
                $pressedEntered = 1;
            }
            break;
        case 'AC':
            $operation = [];
            $number = "";
            echo "0\n";
            break;
        default:
            if($pressedEntered) {
                $number = $key;
                $pressedEntered = 0;
                $operation = [];
            }
            else $number .= $key;
            echo $number . "\n";
    }
}
?>
