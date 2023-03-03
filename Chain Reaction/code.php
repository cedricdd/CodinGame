<?php

$start = microtime(1);

fscanf(STDIN, "%d", $height);
fscanf(STDIN, "%d", $width);
for ($i = 0; $i < $height * 3; $i++) {
    $inputs[] = fgets(STDIN);
}

//We treat each button as a value [0-3]
for($y = 1; $y < $height * 3; $y += 3) {
    for($x = 2; $x < $width * 5; $x += 5) {
        if($inputs[$y -  1][$x] != " ") {
            if($inputs[$y][$x - 1] != " ") $buttons[] = 0;
            else $buttons[] = 1;
        } else {
            if($inputs[$y][$x + 1] != " ") $buttons[] = 2;
            else $buttons[] = 3;
        }
    }
}

function solve(array $buttons, int $index): int {
    global $width, $height;
    
    $direction = 1;
    $rotations = 0;
    $toRotate[$index] = 1;

    while(count($toRotate)) {
        $newToRotate = [];
        $updatedButtons = $buttons;

        foreach($toRotate as $index => $filler) {
            ++$rotations; //Increase rotation count

            $updatedButtons[$index] = ($buttons[$index] + $direction + 4) % 4; //Rotate the button

            $y = intdiv($index, $width);
            $x = $index % $width;

            //Get the adjacent buttons that could be triggered
            $checkLeft = $checkTop = $checkRight = $checkBottom = 0;

            switch($updatedButtons[$index]) {
                case 0: $checkLeft = $checkTop = 1;  break;
                case 1: $checkRight = $checkTop = 1;  break;
                case 2: $checkRight = $checkBottom = 1;  break;
                case 3: $checkLeft = $checkBottom = 1;  break;
            }

            if($checkLeft && $x > 0 && ($buttons[$index - 1] == 1 || $buttons[$index - 1] == 2)) $newToRotate[$index - 1] = 1;
            if($checkRight && $x < $width - 1 && ($buttons[$index + 1] == 0 || $buttons[$index + 1] == 3)) $newToRotate[$index + 1] = 1;
            if($checkTop && $y > 0 && ($buttons[$index - $width] == 2 || $buttons[$index - $width] == 3)) $newToRotate[$index - $width] = 1;
            if($checkBottom && $y < $height - 1 && ($buttons[$index + $width] == 0 || $buttons[$index + $width] == 1)) $newToRotate[$index + $width] = 1;
        }

        $toRotate = $newToRotate; //The new buttons to rotate
        $buttons = $updatedButtons; //We update all the buttons for the next turn
        $direction *= -1; //Alternate anticlockwise & anti-anticlockwise
    }

    return $rotations;
}

$answer = [0, 0];

foreach($buttons as $index => $button) {
    $rotations = solve($buttons, $index);

    if($rotations > $answer[1]) {
        $answer = [$index, $rotations];
    }
}

echo intdiv($answer[0], $width) . " " . ($answer[0] % $width) . PHP_EOL . $answer[1] . PHP_EOL;

error_log(microtime(1) - $start);
