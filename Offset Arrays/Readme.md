# Puzzle
**Offset Arrays** https://www.codingame.com/training/easy/offset-arrays

# Goal
To settle the debate of 0-based vs 1-based indexing I have created a language where you must explicitly state the range of indices an array should have.

For example, given an array definition "A[-1..1] = 1 2 3", you would have:
```
A[-1] = 1
A[0] = 2
A[1] = 3
```

You are given a list of n array definitions and your job is to figure out what number is found in a given index i of an array arr.  
Note that the indexing operations may be nested (in the above example, A[A[-1]] would produce result 3).  

# Input
* Line 1: An integer n for the number of array assignments
* Next n lines: One array assignment per line: array_identifier [ first_index .. last_index ] = last_index - first_index + 1 integers separated by space
* Line n+2: Element to print: arr [ i ]

# Output
* A single integer

# Constraints
* 1 <= n <= 100
* Each array name consists of only uppercase letters (A to Z)
* Array lengths are between 1 and 100 (no empty arrays)
* Indexing operations have at most 50 levels of nesting
* Indices are always within bounds in the test cases
