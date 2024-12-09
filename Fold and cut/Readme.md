# Puzzle
**Fold and cut** https://www.codingame.com/training/hard/fold-and-cut

# Goal
You are given a set of instructions S to fold a piece of paper and then cut off one corner of the folded paper. Your task is to determine how many holes are created when the paper is unfolded.

Folding Directions:  
* R: Fold the right half over the left half.
* L: Fold the left half over the right half.
* T: Fold the top half over the bottom half.
* B: Fold the bottom half over the top half.

The paper can be folded up to seven times, and at least one fold is always performed.

Cutting Positions: Once the paper is folded, one corner is cut:  
* tl: Top-left corner
* tr: Top-right corner
* bl: Bottom-left corner
* br: Bottom-right corner

Special Notes:  
Indentations along the paper's edges after unfolding are not considered holes.  
If no holes can be created (e.g., due to the folding pattern), output 0.  

# Input
* Line 1: A string S of 1 to 7 folding instructions (R, L, T, B) followed by a hyphen and a two-letter corner cut position (tl, tr, bl, br).

# Output
* Line 1: A single integer representing the number of holes created after the paper is unfolded.

# Constraints
* 1 ≤ length of S ≤ 7
