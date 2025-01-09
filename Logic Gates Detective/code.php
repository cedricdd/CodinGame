<?php

$start = microtime(1);

foreach(explode(" ", trim(fgets(STDIN))) as $input) {
    [$c, $v] = explode(':', $input);

    $alphabet[$c] = intval($v);
}

// error_log(var_export($alphabet, 1));

$nodes = explode(" ", trim(fgets(STDIN)));

$n = trim(fgets(STDIN));
for ($i = 0; $i < $n; ++$i) {
    preg_match("/([a-z0-9]+) (or|and|xor) ([a-z0-9]+) -> ([a-z0-9]+)/", trim(fgets(STDIN)), $matches[]);
}

while(true) {
    foreach($matches as [, $a, $op, $b, $c]) {

        if($op == 'or') {
            if(isset($alphabet[$a]) && isset($alphabet[$b])) $alphabet[$c] = ($alphabet[$a] || $alphabet[$b]) ? 1 : 0;
            elseif(($alphabet[$a] ?? 0) || ($alphabet[$b] ?? 0)) $alphabet[$c] = 1;
            elseif(($alphabet[$c] ?? 1) == 0) $alphabet[$a] = $alphabet[$b] = 0;
            elseif(($alphabet[$c] ?? 0) == 1) {
                if(($alphabet[$a] ?? 1) == 0) $alphabet[$b] = 1;
                elseif(($alphabet[$b] ?? 1) == 0) $alphabet[$a] = 1;
            }
        } elseif($op == 'and') {
            if(isset($alphabet[$a]) && isset($alphabet[$b])) $alphabet[$c] = ($alphabet[$a] && $alphabet[$b]) ? 1 : 0;
            elseif(($alphabet[$a] ?? 1) == 0 || ($alphabet[$b] ?? 1) == 0) $alphabet[$c] = 0;
            elseif(($alphabet[$c] ?? 0) == 1) $alphabet[$a] = $alphabet[$b] = 1;
            elseif(($alphabet[$c] ?? 1) == 0) {
                if(($alphabet[$a] ?? 0) == 1) $alphabet[$b] = 0;
                elseif(($alphabet[$b] ?? 0) == 1) $alphabet[$a] = 0;
            }
        } elseif($op == 'xor') {
            if(isset($alphabet[$a]) && isset($alphabet[$b])) $alphabet[$c] = ($alphabet[$a] ^ $alphabet[$b]) ? 1 : 0;
            elseif(($alphabet[$c] ?? 1) == 0) {
                if(isset($alphabet[$a])) $alphabet[$b] = $alphabet[$a];
                elseif(isset($alphabet[$b])) $alphabet[$a] = $alphabet[$b];
            } elseif(($alphabet[$c] ?? 0) == 1) {
                if(isset($alphabet[$a])) $alphabet[$b] = ($alphabet[$a] + 1) % 2;
                elseif(isset($alphabet[$b])) $alphabet[$a] = ($alphabet[$b] + 1) % 2;
            }
        }
    }

    foreach($nodes as $node) {
        if(!isset($alphabet[$node])) continue 2;
    }

    break;
}

$output = "";

foreach($nodes as $node) $output .= $alphabet[$node];

echo $output . PHP_EOL;

error_log(microtime(1) - $start);
