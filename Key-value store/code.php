<?php

$values = [];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $inputs = explode(' ', trim(fgets(STDIN)));

    error_log(var_export($inputs, 1));

    switch(array_shift($inputs)) {
        case 'SET': 
            foreach($inputs as $input) {
                [$key, $value] = explode('=', $input);

                $values[$key] = $value;
            }
            break;
        case 'GET':
            $output = [];

            foreach($inputs as $input) {
                $output[] = $values[$input] ?? 'null';
            }

            echo implode(" ", $output) . PHP_EOL;
            break;
        case 'EXISTS':
            $output = [];

            foreach($inputs as $input) {
                $output[] = isset($values[$input]) ? 'true' : 'false';
            }

            echo implode(" ", $output) . PHP_EOL;
            break;
        case 'KEYS':
            echo (implode(" ", array_keys($values)) ?: 'EMPTY') . PHP_EOL;
            break;
        default: error_log("default");
    }
}

