# Puzzle
**Longest Increasing Subsequence** https://www.codingame.com/training/medium/longest-increasing-subsequence

# Goal
Find the length of the longest increasing subsequence in a list.

A subsequence is a sequence of numbers that can be derived from the original list by deleting some or all of the elements without changing the order of the remaining elements.  
An increasing subsequence is a subsequence in which the elements are in increasing order.  

For example, given the list [5, 2, 8, 6, 3, 6, 9, 7], the longest increasing subsequence is [2, 3, 6, 9] or [2, 3, 6, 7], both of which have a length of 4.

Example:  
Input: [5, 2, 8, 6, 3, 6, 9, 7]  
Output: 4  

If you remove 5, 8 and 6 (the first one) you get the longest increasing subsequence.

# Input
* Line 1: An integer N for the size of the list
* Next N lines: An integer P that is part of the list

# Output
* Line 1: An integer that represents the length of the longest increasing subsequence

# Constraints
* 2 <= N <= 2568
