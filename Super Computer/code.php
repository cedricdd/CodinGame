<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $J, $D);
    $tasks[] = [$J, $J + $D];
}

//Sort by end of task
usort($tasks, function($a, $b) {
    return $a[1] <=> $b[1];
});

$end = 0;
$count = 0;

//Add tasks if previous task is over, otherwise skip task
foreach($tasks as $task) {
    if($task[0] >= $end) {
        $end = $task[1];
        ++$count;
    }
}

echo $count;
?>
