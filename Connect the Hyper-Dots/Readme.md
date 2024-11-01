# Puzzle
**Connect the Hyper-Dots** https://www.codingame.com/training/medium/connect-the-hyper-dots

# Goal
A collection of labeled points is provided in n-dimensional space.  
Starting at the origin, find the nearest point, and then the nearest unused point from that point, and so on until all points have been connected.

The concatenated labels within an orthant spell a word. Therefore, these words need to be spaced when crossing some axis, that is, when entering a new orthant.

Some points labeled with punctuation will have a zero coordinate.  
In the tests, the hyphen in criss-cross is an example. A zero coordinate is not considered crossing the axis.  
Thus, do not add a space except when the sign change is fully within a new orthant from previous. 

# Input
* Line 1: Two space separated integers count for the number of points and n for the dimensions
* Next count lines: A single character label and the integer coordinates of each point, separated by spaces

# Output
* Line 1: The string phrase as a concatenation of all labels connected by shortest distance, and spaced when changing orthants

# Constraints
* 1 < count < 25
* 1 < n < 10
* ‖coordinates‖ < 1000
* Each label is a letter or punctuation mark
* The only ties in nearest distance are to duplicate points with the same label
