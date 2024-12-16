# Puzzle
**Kaprekar's routine** https://www.codingame.com/training/medium/kaprekars-routine

# Goal
Suppose you're given a positive integer n1. 
You can build another integer n2 = D(n1) - A(n1) , where D(x) is integer x whose digits are in descending order, and A(x) is integer x whose digits are in ascending order.  

Then you can repeat the process another time with n3 = D(n2) - A(n2), and so on, until you get a cycle.

Your program must return the cycle for any input n1.

All ni numbers must be of same size . For example,if you're given n1 = "123", and you get ni=4 at some iteration, it must be writen as "004"

Example of a 2 digit number ending in a cycle of length 5:
```
n=09
n2=90-09=81
n3=81-18=63
n4=63-36=27
n5=72-27=45
n6=54-45=09
```

Here cycle is "09 81 63 27 45"

# Input
* Line 1:number n

# Output
* Line 1: the cycle as a list of integers separated by space

# Constraints
* 0 < n1 < 99999999
