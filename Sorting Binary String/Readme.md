# Puzzle
**Sorting Binary String** https://www.codingame.com/contribute/view/68590918a02922d23b4f17c1e877c4c183cd1

# Goal
You are given a binary string A of length n. You also have a set S of length (n × (n + 1)) ÷ 2 consisting of pairs of integers.  
All elements in S consisting of pairs of integers selected from 1 to n (both inclusive). Each pair is sorted in ascending order and may contain same or different integers. All pairs in S are different.  

Furthermore, let s be 0.  
For each pair (i, j) in S, sort A's digits from the i-th position to the j-th position (note that A's index starts from 1).   
Then compare it to the original A. If the original A is the same as the sorted A, increase s by 1. Reset A to the original A before doing the same procedure for the next pair.  

What is the final value of s? 

Note: In Example:  
S denotes (1,1), (1,2), (1,3), (2,2), (2,3), (3,3).  
For all pairs in S with the second element equivalent to the first element: the sorted A is always the same as the original A. In our case, there are 3 such pairs. Hence increase s by 3.  
The only other pair that results in the sorted A being the same as the original A is (2,3). Hence increase s by 1.  
Therefore the final value of s is 4.  

# Input
* n digits A consisting of only 0s and 1s. This input will be formatted as a string.

# Output
* An integer for the final value of s.

# Constraints
* 1 <= n <=4000
