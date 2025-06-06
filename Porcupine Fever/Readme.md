# Puzzle
**Readme.md** https://www.codingame.com/training/medium/porcupine-fever

# Goal
You have a hobby of visiting a porcupine farm. Porcupines are kept in cages and regularly fed.   
They are usually healthy and have been one of the rodents with longest lifespans, but some of these porcupines are sick.  

Every year, each porcupines who were sick last year will cause 2 healthy porcupines in the same cage to be sick, and then die.

Simulate to find the total amount of surviving porcupines after every year. Stop if all the porcupines are dead (do not repeat "0"s after the first time).

# Input
* Line 1: Integer N, the amount of cages.
* Line 2: Integer Y, the number of years.
* Next N lines: Three space-separated integers S, H and A, the amounts of sick, healthy and alive porcupines in the cage respectively.

# Output
* Y or fewer lines of integers of porcupines alive.
* Line 1 is year 1, not year 0. Any sick porcupines die first.

# Constraints
* 0 ≤ N < 500
* 0 < Y < 100
* 0 ≤ S, H, A < 10,000,000
* S + H is A
