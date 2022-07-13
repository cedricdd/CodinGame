<?php

fscanf(STDIN, "%d", $N);

for($i = 0; $i < $N; ++$i) {
   $string = str_repeat(" ", $N + ($N - $i - 1)) . str_repeat("*", ($i * 2 + 1));

   if($i == 0) $string[0] = ".";

   echo $string . "\n";
}
for($i = 0; $i < $N; ++$i) {
    echo str_repeat(" ", ($N - $i - 1)) . str_repeat("*", ($i * 2 + 1)) . str_repeat(" ", (2 * $N - 1) - $i * 2) . str_repeat("*", ($i * 2 + 1)) . "\n";
 }
?>
