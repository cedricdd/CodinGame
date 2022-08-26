<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $canBeQueue = 1;
    $canBeStack = 1;
    $canBePriority = 1;

    $queue = new SplQueue();
    $stack = new SplStack();
    $priority = new SplPriorityQueue();

    foreach(explode(" ", stream_get_line(STDIN, 1024 + 1, "\n")) as $operation) {
        $type = $operation[0];
        $integer = intval(substr($operation, 1));

        if($type == "i") {
            $queue->push($integer);
            $stack->push($integer);
            $priority->insert($integer, $integer);
        } else {
            if(!$queue->count() || $queue->dequeue() != $integer) $canBeQueue = 0;
            if(!$stack->count() || $stack->pop() != $integer) $canBeStack = 0;
            if(!$priority->count() || $priority->extract() != $integer) $canBePriority = 0;
        }
    }

    if($canBeQueue + $canBeStack + $canBePriority > 1) echo "unsure\n";
    elseif($canBeQueue) echo "queue\n";
    elseif($canBeStack) echo "stack\n";
    elseif($canBePriority) echo "priority queue\n";
    else echo "mystery\n";
}
?>
