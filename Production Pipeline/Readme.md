# Puzzle
**Production Pipeline** https://www.codingame.com/contribute/view/1207291aeed6e8753edf7cb02613af87c69731

# Goal
There are N different sequential processes in a production pipeline which must be executed, identified by a number from 1 to N, and K constraints given in the form "[process1] < [process2]", which means that the first provided process must run before the second provided process.

Find a valid processing order for all processes that respects the constraints. If none exists, output INVALID. Otherwise output the processes in their order, separated by spaces. In case the order of two processes doesn't matter, use the smaller process first.

# Input
* Line 1: An integer N for the number of processes.
* Line 2: An integer K for the number of contraints.
* Next K lines: A constraint string consisting of two process numbers p1 and p2, separated by <.

# Output
* Line 1: The space-separated list of processes in processing order, or the text INVALID.

# Constraints
* 0 < N <= 250
* 0 <= K <= 250
* 1 ≤ p1, p2 ≤ N

The same process number can appear in multiple constraints.
