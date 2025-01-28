# Puzzle
**Folding a Note** https://www.codingame.com/training/medium/folding-a-note

# Goal
You are stuck in detention again and your friend wants to send you a note from across the room. However, the detention supervisor is clever and knows that if he intercepts a folded note, he can intercept and decode the message it contains by unfolding the paper. To thwart his ingenuity, you have both agreed on a procedure beforehand: she will send you an unfolded note, and to decode it, you will need to fold it up until there is only one character on each ply, and then read the plies from top to bottom in order to recover the intended message.

In the physical world, some folds will have the effect of reversing the side of the paper on which some characters appear when reading the final message, as well as their orientation. We ignore this and read the characters on each ply, regardless of which side of the paper they are on or how they are rotated.

The folds will occur in a specific order, until only one character is on each ply:  
* The first fold will be from right to left, that is, the right half of the note is folded on top of the left half
* The second fold (if it occurs) will be from bottom to top
* The third fold (if it occurs) will be from left to right
* The fourth fold (if it occurs) will be from top to bottom
* Subsequent folds, if they occur, will continue to cycle in this order.

*Example*  
You receive the unfolded note:  
```
12
34
```
After the first fold, from right to left, the note now has two plies,which are, from top to bottom:  
```
2
4
and
1
3
```
After the second and final fold from bottom to top, the note has 4 plies each containing one character, and thus the final message is obtained by reading the plies from top to bottom:
```
3421
```

# Input
* Line 1: An integer N, the number of lines in the note.
* Next N lines: A string L of N characters representing a line of the note

# Output
* A string of N×N characters representing the folded note as read ply by ply from top to bottom.

# Constraints
* 0 < N ≤16
* N is always a power of 2.
