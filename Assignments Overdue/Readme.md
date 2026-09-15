# Puzzle
**Assignments Overdue** https://www.codingame.com/ide/demo/1579685bc3264ff110d147e653946951eda2457

# Goal
On the first day of school after summer vacation, a student realizes he has N unfinished assignments that are all due today. The student promises to start working on them immediately.

For each assignment i, where 1 ≤ i ≤ N, Dᵢ is the number of days required to complete it, and Pᵢ is the penalty (in credits) incurred for each day it is overdue.

The student can work on only one assignment per day and cannot work overtime. Once an assignment is started, it must be worked on continuously until finished.

Determine the optimal sequence of assignments to work on, that minimizes the total penalty. If multiple sequences produce the same minimum penalty, choose the lexicographically smallest sequence.

Example:
Three assignments are due but unfinished.
```
           |               | Penalty per
Assignment | Days required | overdue day
-----------+---------------+-------------
    1      |       2       |      5
    2      |       1       |     10
    3      |       3       |      2
```


The best arrangement is to finish them in this order: 2 1 3.
```
┌───◀ Today (due date)
├───◀ Assignment 2 done. Overdue for 1 day.  Penalty 10
├───┤
├───◀ Assignment 1 done. Overdue for 3 days. Penalty 15
├───┤
├───┤
├───◀ Assignment 3 done. Overdue for 6 days. Penalty 12
├───┤                                        ──────────
├─:─┤                                          Total 37
  :                                           (minimum)
```

# Input
* Line 1: An integer N, representing the total number of assignments.
* Next N lines: Each line contains two space-separated integers, D P.
* D is the number of days needed to complete the assignment, and P is the penalty cost per overdue day.

# Output
* Line 1: The optimal sequence of assignments, represented by their 1-indexed positions and separated by single spaces.
* Line 2: An integer, the minimum total penalty to suffer when all assignments are submitted.

# Constraints
* 1 ≤ N ≤ 100
* 1 ≤ D ≤ 100
* 0 ≤ P ≤ 1000
