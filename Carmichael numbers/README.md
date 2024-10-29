# Puzzle
**Carmichael numbers** https://www.codingame.com/training/medium/carmichael-numbers

# Goal
You might know Fermat’s small theorem:  
If n is prime, then for any integer a, we have a^n ≡ a mod n, that means that a^n and a have the same remainder in the euclidian division by n.

There are numbers, called Carmichael numbers, that are not prime but for which the equality remains true for any integer a.  
For example, 561 is a Carmichael numbers because for any integer a, a^561 ≡ a mod 561. It’s in fact the smallest Carmichael number.

You have to tell if the given number is a Carmichael number or not. Beware, you might be given a prime number.

# Input
* A single number n.

# Output
* YES if n is a Carmichael number, or NO if it’s not.

# Constraints
* 1 ⩽n ⩽ 1000000
