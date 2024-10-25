# Puzzle
**Bouncing Barry** https://www.codingame.com/training/medium/bouncing-barry

# Goal
Barry the bouncing bunny is a bit braindead. Barry mindlessly jumps around on an infinitely large square grid, comprising tiles that initially display the . character. Each time Barry lands on a tile, the tile toggles between displaying . and #.

Barry's bouncing behavior is described with a space-separated sequence of directions d_1 d_2 d_3... followed by an index-matched integer sequence for bounce count b_1 b_2 b_3... Directions are any of the four cardinal directions NSEW.  
Bounce count describes how many tiles Barry bounces forward in a straight line. Turning does not count as a bounce.

After Barry has finished his bouncing business, print the appearance of the floor, cropped to the smallest rectangle that includes all #'s.

If no tiles show # at the end of Barry's bouncing, simply print . instead.

# Input
* Line 1: A string containing a space-separated sequence of characters NSEW representing bouncing direction
* Line 2: A string containing a space-separated sequence of integers representing bounce count

# Output
* A map of the floor, consisting of characters # and .

# Constraints
* 1 ≤ bounces per action ≤ 30000
* 1 ≤ sequence length ≤ 500
