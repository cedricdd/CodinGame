<?php

$text = fgets(STDIN);
$format = fgets(STDIN);

if(preg_match("/^" . strtr(preg_replace("/([^a-zA-Z0-9])/", "\\\\$1", $format), ["\?" => ".", "\~" => ".*"]) . "$/", $text)) echo "MATCH" . PHP_EOL;
else echo "FAIL" . PHP_EOL;
