# Puzzle
**Rod cutting problem** https://www.codingame.com/training/medium/rod-cutting-problem

# Goal
The rod cutting problem consists of cutting a rod in some pieces of different length, each having a specific value, such that the total value is maximized.

For example, consider that the rods of length 1, 2, 3 and 4 are marketable with respective values 1, 5, 8 and 9.  
A rod of length 4 can then be cut in pieces in five different ways:
```
• 0×1 + 0×2 + 0×3 + 1×4 → total value: 0×1 + 0×5 + 0×8 + 1×9 =  9
• 1×1 + 0×2 + 1×3 + 0×4 → total value: 1×1 + 0×5 + 1×8 + 0×9 =  9
• 0×1 + 2×2 + 0×3 + 0×4 → total value: 0×1 + 2×5 + 0×8 + 0×9 = 10
• 2×1 + 1×2 + 0×3 + 0×4 → total value: 2×1 + 1×5 + 0×8 + 0×9 =  7
• 4×1 + 0×2 + 0×3 + 0×4 → total value: 4×1 + 0×5 + 0×8 + 0×9 =  4
```
The optimal cut is thus two pieces of length 2 which gives a total value of 10.

You can make pieces that are not marketable, but theses pieces will have a value of 0.

# Input
* First line: L the length of the rod
* Second line: N the number of different pieces that are marketable.
* Next N lines: length value of each marketable piece, separated by a space.

# Output
* The maximum total value that can be obtained from the cut of the rod in different pieces.

# Constraints
* 0 < L ≤ 100 000
* 0 < N < 50
* 0 < length ≤ 10 000 000 000
* 0 ≤ value
