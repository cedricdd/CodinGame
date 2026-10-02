<?php

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    $line = stream_get_line(STDIN, 100 + 1, "\n");

    //Removing tokens
    preg_match_all("/(?<![A-Za-z]|token=)(token=(?!token=)[0-9a-zA-Z]+)(?![A-Za-z0-9])/", $line, $tokens);

    foreach($tokens[0] as $token) {
        $line = str_replace($token, "token=[TOKEN_REDACTED]", $line);
    }

    //Removing credit cards
    preg_match_all("/(?<![0-9]{4}-|[A-Za-z0-9])([0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4})(?![A-Za-z0-9]|-[0-9]{4})/", $line, $cards);

    foreach($cards[0] as $card) {
        $line = str_replace($card, "[CARD_REDACTED]", $line);
    }

    echo $line . PHP_EOL;
}
