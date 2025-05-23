# Puzzle
**Euclid's Algorithm** https://www.codingame.com/training/easy/euclids-algorithm

# Goal
In this puzzle you will have to calculate the greatest common divisor (GCD) of two numbers (a and b) thanks to Euclid's algorithm, but you will not have to return just the result but also the different calculation steps.

*Example:*  
If you are asked to calculate the GCD of 25 and 3 you must return:
```
25=3*8+1
3=1*3+0
GCD(25,3)=1
```

*Reminder:*  
In mathematics, Euclid's algorithm is an algorithm that calculates the GCD of two integers, that is, the largest integer that divides the two integers, leaving a zero remainder. Euclid's algorithm follows a simple method which is defined by the following equality:

GCD(a,b) = GCD(b,r) with r = a%b

Divide b by the remainder of the division of b by a and continue until you get r=0.

# Input
* Line 1: An integer a and integer b separated by a space

# Output
* The different stages of calculating Euclid's algorithm

# Constraints
* a > b
* a,b > 0
