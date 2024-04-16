<?php

//Generate all the fibonacci numbers up to $n
function fibo(int $n): array {
    $fibo = [0, 1];
    $index = 1;

    while($fibo[$index] < $n) {
        $fibo[] = $fibo[$index - 1] + $fibo[$index];
        ++$index;
    }

    return $fibo;
}

function solve(array $fibo, int $n): array {
    $solution = [];

    while($n) {
        //Find the next biggest fibonacci number we can use
        $fibValue = array_pop($fibo);

        /**
         * We know that $n - fib(i) has its own representation as sum of non-neighbouring Fibonacci numbers from the theorem
         * The only consecutive could be if $n - fib(i) uses fib(i - 1) in its representation but if that was the case then 
         * the closest fib value from $n would be fib(i + 1) and not fib(i) since fib(i) + fib(i - 1) is fib(i + 1)
         */
        if($fibValue <= $n) {
            $solution[] = $fibValue;
            $n -= $fibValue; 
        }
    }

    return $solution;
}

fscanf(STDIN, "%d", $N);

echo implode("+", solve(fibo($N), $N)) . PHP_EOL;
