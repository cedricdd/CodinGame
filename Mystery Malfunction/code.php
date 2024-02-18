<?php

$issues = [];

fscanf(STDIN, "%d", $c);
for ($i = 0; $i < $c; $i++) {
    $report = trim(fgets(STDIN));

    if($report == "Item REMAINS at teleporter") $issues[] = "DISASSEMBLER";
    if($report == "Item DOESNT APPEAR at location") $issues[] = "REASSEMBLER";
    if($report == "Item appears at WRONG LOCATION") $issues[] = "LOCATOR";
}

if(count($issues) == 3) echo "MAIN COMPUTER" . PHP_EOL;
else echo implode("\n", $issues) . PHP_EOL;
