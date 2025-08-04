# Puzzle
**Swapping Elements** https://www.codingame.com/training/medium/swapping-elements

# Goal
Given n - the number of elements - and the elements themselves, find the minimum number of swaps needed to make the elements strictly increasing.

Each element can be:
- A float, or
- A string

The value of the float is itself, while the value of the string is the sum of all the ASCII values of the characters in the string.

If it is not possible to swap elements to make them strictly increasing, output -1.

The order of the elements is the order the element is given.  
For example, if the input is:
```
3
a
99
b
```

The order would be [a, 99, b], which would take 1 swap (99 with b) to be strictly increasing.  
Note: A number with a negative sign (-) like -123 would be considered a float, not a string.  

# Input
* Line 1: An integer n representing the number of elements.
* Next n lines: A string s representing the element, which could also be a float.

# Output
* Line 1: An integer representing the minimum number of swaps needed to make the order strictly increasing. If it is not possible, output -1.

# Constraints
* 1 ≤ n, length of s ≤ 200
