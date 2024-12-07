# Puzzle
**Domino Puzzle** https://www.codingame.com/training/medium/domino-puzzle

# Goal
Determine how many dominoes will still stand after the push.

We have a field of standing domino pieces, and we will push the top left corner piece. After the chain reaction, how many domino pieces will still be standing?

You receive a square shape map of characters, with N lines, and N characters in every line.  
The characters represent visually the domino pieces and their direction.  
You can find these characters:  
* ".", which represents a place without a domino piece.
* "|", which represents a vertical standing domino piece, which can hit something to the left or to the right of it. It can be hit from anywhere but from upwards and downwards.
* "-", which represents a horizontally standing domino piece, which can hit something in upward or downward direction to it. It can be hit from anywhere but from left and right.
* "\", which represents a diagonally standing domino piece, which can hit something to its left and downwards, or its right and upwards, including the diagonal place in those directions. It can be hit from anywhere but from left-top diagonally, or right-bottom diagonally.
* "/", which represents a diagonally standing domino piece, which can hit something to its left and upwards, or its right and downwards, including the diagonal place in those directions. It can be hit from anywhere but from right-top diagonally, or left-bottom diagonally.

The pieces will fall to the opposite direction to the direction they were hit from, and will hit other domino pieces from that direction.

We always hit the first domino on the top left corner, which can be either a vertical standing (falls to the right), horizontal standing (falls downwards), or a "/" piece, which falls downwards and to the right and diagonally too. The first piece will never be a "\" piece.

I didn't add any other difficulties to the examples, for example order doesn't matter, because the answers will be the same. This is changed in the second version.

Example explanation:  
- We push the first piece which will fall to the right, hitting the second piece, which is a "/".
- This will hit three locations: downwards an empty place, to the right a vertical one ("I"), and another vertical one diagonally. The empty place will do nothing, and the diagonally placed vertical piece will cause no other reaction, because it would hit a horizontal piece, from the side.
- The other vertical piece will hit the last piece in the first row, which is a diagonal, and will hit the one downwards to it.
- This piece is horizontal, and will fall downwards, hitting the diagonal piece there.
- The diagonal piece will hit an empty place to the left, a diagonal piece downwards, and a vertical one left-downwards.
- The diagonal piece will hit nothing new, but the same vertical piece.
- And in the last line, the vertical pieces will hit each other falling to the left.

# Input
* Line 1: An integer N for the length of one side of the domino map.
* Next N lines: N space-separated characters.

# Output
* Line 1: The number of pieces standing after the chain reaction.

# Constraints
* 0 < N ≤ 10

