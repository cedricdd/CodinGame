<?php
fscanf(STDIN, "%d", $action);
$header = stream_get_line(STDIN, 10 + 1, "\n");
$passphrase = stream_get_line(STDIN, 10 + 1, "\n");
fscanf(STDIN, "%d %d", $posslash, $posdot);
$key = stream_get_line(STDIN, 10 + 1, "\n");
$message = strtoupper(stream_get_line(STDIN, 1000 + 1, "\n"));

//Remove unsupported characters
if($action == 1) {
    $message = preg_replace("/[^A-Z0-9\.]/", "", $message);
}

//First line of the checkerboard
foreach(str_split($header) as $i => $number) {
    if($passphrase[$i] == " ") $spaces[] = $number; //Indexes of other lines
    else $checkboard[$number] = $passphrase[$i];
}

//The characters left to add in the checkerboard 
$alphabet = array_reverse(array_diff(range('A', 'Z'), str_split($passphrase)));

//Finish building the checkerboard
for($i = 0; $i < 20; ++$i) {
    if($i == $posdot) $value = ".";
    elseif($i == $posslash) $value = "/";
    else $value = array_pop($alphabet);

    $checkboard[$spaces[intdiv($i, 10)] . $header[$i % 10]] = $value;
}

$checkboard2 = array_flip($checkboard);

$digitEncoded = "";
//Use the checkerboard to generate the encoded string with on digits
foreach(str_split($message) as $character) {
    if(is_numeric($character)) $digitEncoded .= $checkboard2["/"] . $character;
    else $digitEncoded .= $checkboard2[$character];
}

//Generate key with the proper length
$key = str_pad($key, strlen($digitEncoded), $key);

//Modulo step
foreach(str_split($digitEncoded) as $i => $character) {
    if($action == 1) {
        //Encoding, sum mod 10
        $digitEncoded[$i] = ($digitEncoded[$i] + $key[$i]) % 10;
    } else {
        //Decoding, sub mod 10, no negative number
        $digitEncoded[$i] = ($digitEncoded[$i] - $key[$i] + 10) % 10;
    }  
}

$output = "";
$index = "";

//Last step encode the digits using the checkerboard
for($i = 0; $i < strlen($digitEncoded); ++$i) {

    $index .= $digitEncoded[$i];
    
    if(isset($checkboard[$index])) {
        //We are decoding, we have the special case where / was used to encode a number
        if($action == 0 && $checkboard[$index] == "/") {
            $output .= $digitEncoded[++$i];
        } else $output .= $checkboard[$index];

        $index = "";
    } 
}

echo $output;
?>
