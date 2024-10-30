# Puzzle
**Closest Number** https://www.codingame.com/training/hard/closest-number

# Goal
You are given two positive integers N and M.  
Your objective is to rearrange the digits in M to get the closest possible number to N (the distance between two numbers is the absolute value of their difference).  
Each digit must be used exactly once, hence the solution is a permutation of the digits in M.  

# Input
* A single line: Two positive integers N and M.  
* N and M never start with 0.  

# Output
* A single line: The permutation of the digits in M that is closest to N.  
* If there are two optimal permutations equally close to N, you should output the one with the lowest numeric value.  
* If the solution has leading zeros, they must be omitted.  

# Constraints
* 1 ≤ N, M < 10^1000
