# Puzzle
**Equalizing arrays** https://www.codingame.com/training/medium/equalizing-arrays

# Goal
You are given two arrays of non-negative integers A and B. You can subtract some integer x from any element A[i] and increase A[i-1] or A[i+1] by x.   
After each operation all values in array A should remain non-negative.   
You must find the minimum number of operations to equalize the arrays and the correct order of their use.   
If there are several orders of operations possible then output the one that is lexicographically minimal.  

To compare two orders of operations consider them as a sequences of integers in a one-dimensional array.   
Let's compare the first element that is different in the sequences. One sequence will be lexicographically smaller than the other where this element is smaller.

# Input
* Line 1 : An integer N size of arrays A and B.
* Line 2 : Array A of N non-negative integers.
* Line 3 : Array B of N non-negative integers.

# Output
* Line 1 : Minimum number operations K to equalize arrays.
* Line 2...K+1 : Next K lines contain three numbers P D V: array index for subtract (1-based indexing), direction to increase and value modify respectively.

# Constraints
* 1 ≤ N ≤ 100
* 0 ≤ A[i], B[i] ≤ 100 000
* ∑ A[i] = ∑ B[i]
* 1 ≤ P ≤ N
* D is integer number -1 or 1
* 1 ≤ P + D ≤ N
* 0 < V
