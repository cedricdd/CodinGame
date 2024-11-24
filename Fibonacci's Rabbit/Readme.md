# Puzzle
**Fibonacci's Rabbit** https://www.codingame.com/training/easy/fibonaccis-rabbit

# Goal
The Fibonacci sequence has first been introduced to calculate the growth of rabbit populations.  
In this puzzle you will have to calculate how many pairs of rabbits will be born at a given moment.  
To do so, you will know how many pairs of rabbits you introduce at year 0 (we'll denote them as F0) as well as the age (in years) the rabbits can reproduce.   
Each pair of rabbits will always give birth to one pair each year of reproduction. (e.g. if rabbits can reproduce from 2 to 3 you will have F(i) = F(i-2) + F(i-3)).

# Input
* 1st line Two space-separated integers F0, representing the initial number of pairs of rabbits at year 0 and N, representing the number of years to simulate.
* 2nd line Two space-separated integers a and b, representing the inclusive range of age (in years) rabbits can give birth.

# Output
* An Integer FN, the number of pairs of newly born rabbits at year N.

# Constraints
* 0 ≤ F0 ≤ 100
* 0 ≤ N ≤ 60
* 0 < a ≤ b ≤ 12
* FN < 2^64
