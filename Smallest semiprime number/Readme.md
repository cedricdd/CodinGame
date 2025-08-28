# Puzzle
**Smallest semiprime number** https://www.codingame.com/contribute/view/133203aed5af11446b91ab11bfc2236ae96d86

# Goal
A semiprime number is a number that is the product of two prime numbers.  
Given a list of N digits, find two prime numbers (which can be the same) whose product is the smallest semiprime number that can be formed by rearranging all the given digits.  

example:  
N=2  
digits: 1 2  
With the two digits 1 and 2, we can write 12 and 21.  
12=3*2*2 -> there are three factors, so it's not a good candidate.  
21=3*7 -> there are two prime factors, so the correct answer is 3 7.  

# Input
* Line 1 : An integer N for the number of digits that must appear.
* Line 2 : N digits separated by a space.

# Output
* Line 1 : two prime numbers a and b separated by a space (in non-decreasing order) whose product contains all the given digits, or IMPOSSIBLE if no such pair exists.

# Constraints
* 0 < N < 10
