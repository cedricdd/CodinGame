<?php

//Check if a position is part of the data or not
function isData(int $x, int $y): bool {
    global $W, $H;

    //Top left 
    if($x < 6 && $y < 4) return false;
    //Top right
    if($x >= $W - 6 && $y < 4) return false;
    //Bottom left
    if($x < 6 && $y >= $H - 4) return false;
    //Bottom right
    if($x >= $W - 6 && $x <= $W - 4 && $y >= $H - 4 && $y <= $H - 2) return false;

    return true;
}

//Get the mask to apply to the position
function generateMask(int $x, int $y): int {
    global $W, $H;

    $distX = abs($W - 1 - $x);
    $distY = abs($W - 1 - $y);

    return ($distY & 1) ? (($distX & 1) ? 1 : 0) : (($distX & 1) ? 0 : 1);
}

fscanf(STDIN, "%d", $W);
fscanf(STDIN, "%d", $H);
for ($i = 0; $i < $H; $i++){
    $code[] = stream_get_line(STDIN, 1024 + 1, "\n");
}

$data = "";
$direction = 1;

//Read the data
for($x = $W - 1; $x >= 0; --$x) {
    //Going up
    if($direction == 1) {
        for($y = $H - 1; $y >= 0; --$y) {
            if(isData($x, $y) == false) continue;

            $bit = $code[$y][$x] == " " ? 0 : 1;
            $data .= $bit ^ generateMask($x, $y);

        }
    } //Going down 
    else {
        for($y = 0; $y < $H; ++$y) {
            if(isData($x, $y) == false) continue;

            $bit = $code[$y][$x] == " " ? 0 : 1;
            $data .= $bit ^ generateMask($x, $y);
        }
    }

    $direction ^= 1;
}

$BOM = substr($data, 0, 8); //Begin of message - 8 bits
$message = substr($data, 8, strlen($data) - 15); 
$EOM = substr($data, -7); //End of message - 7 bits
$answer = "";
$clear = $BOM[0];
$key = $clear ? 0 : bindec(substr($BOM, 1));

foreach(str_split($message, 7) as $binary) {
    //Incomplete binary
    if(strlen($binary) != 7) break;

    $characterCode = bindec($binary) ^ $key;

    //Message is over, invalid character
    if($characterCode < 32 || $characterCode > 126) break;
    else $answer .= chr($characterCode);
}

echo $answer . PHP_EOL;
