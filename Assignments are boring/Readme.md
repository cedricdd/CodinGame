# Puzzle
**Assignments are boring** https://www.codingame.com/training/medium/assignments-are-boring

# Goal
Story:  
Jasmine is on her desk, looking at the pile of papers that has been assigned to her for the week. But her mind has been wandering outside, thinking "How many days it would take to finish writing any given number of papers given she writes the minimum number for each paper?" You must help her track this for each day until the last day where the number of papers left is 0.

Rules:  
To understand how she completes writing the papers in this hypothetical world, let's assume she has n papers where each paper has a page count from a range of 0 to 2 ^ p

1) Find the lowest page count from the n papers
2) Subtract up to that page count for all of the n papers.
3) Ignore the ones who have 0 pages left for the next turn  
Repeats these steps until finally, all papers have 0 pages left to be completed.


To obtain the page count for the papers, we use a linear congruential generator expression (random number generator):  
```Z(n+1) = (1664525 * Z(n) + 1013904223) MOD 2 ^ Power```

Here, the initial value of Z(0) is passed as seed [but not kept in the list of papers] and power as power from the IDE. Then the expression is executed for N number of times to find the number of pages in sequential order.

For testcase 1: seed = 7, paper = 5, power = 3  
--> For the number of pages of the first paper, we use the expression (1664525 * 7 + 1013904223) MOD 2 ^ 3 and obtain the first value as 2  
--> For the number of pages of the second paper, we use the expression (1664525 * 2 + 1013904223) MOD 2 ^ 3 and obtain the second value as 1 …..  

We repeat this until all of the pages counts for the starting list are obtained as [ 2, 1, 4, 3, 6 ]

Table representation:
```
2   1   4   3   6       # The starting list is always ignored
-------------------------------
1   0   3   2   5	 [4 papers left]
0   0   2   1   4	 [3 papers left]
0   0   1   0   3	 [2 papers left]
0   0   0   0   2	 [1 papers left]
0   0   0   0   0	 [0 papers left]
```

Output: 4 3 2 1 0

Note: If the initial list of page counts has 0 present, it is considered only for the starting list as the lowest page count, and not later on.

# Input
* Line 1: a single integer seed that is the seed of the LCG generator.
* Line 2: an integer paper representing the number of elements to be obtained by using the seed.
* Line 3: an integer power representing the power of the modulo constant.
  
# Output
* A sequence of numbers separated by a space where each number represents the number of assignments left after each day.

# Constraints
* 0 < papers < 10^8
* 1 < power < 8
