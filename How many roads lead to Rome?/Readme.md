# Puzzle
**How many roads lead to Rome?** https://www.codingame.com/training/medium/how-many-roads-lead-to-rome

# Goal
Someone just told you all roads lead to Rome.  
As a matter of fact, this is not true.  
In order to restore scientific truth, you must write a program that counts the actual number of paths from Paris to Rome, where cities are visited at most once.  
To start with, you are given a collection of all paths that directly connect two individual cities and where each city is defined by a number from 1 to 100.   
Paris has label 1, and Rome has label 100.  
One may use paths both ways.  

Let us illustrate the problem with a simple example:  
you are given 5 paths:  
```
1 50
50 100
25 50
75 25
100 75
```

So, we have 5 cities:
- 1 (Paris)
- 25
- 50
- 75
- 100 (Rome)

There are 2 roads from Paris to Rome:  
1 -> 50 -> 100  
1 -> 50 -> 25 -> 75 -> 100  

# Input
* Line 1: An integer N corresponding to the total number of paths
* N next lines: Two integers A and B corresponding to the two cities the path connects.

# Output
* The number of roads from Paris to Rome

# Constraints
* 1 ≤ N ≤ 100
* 1 ≤ A,B ≤ 100
