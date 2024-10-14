# Puzzle
**1×1×1 Rubik’s cube movements** https://www.codingame.com/training/easy/111-rubiks-cube-movements

# Goal
A 2×2×2 Rubik's cube is quite complicated. In this puzzle, we will focus on the mono-cube, the 1×1×1 Rubik's cube!

You are given a set of rotations and two faces. Apply the rotations to the cube and locate the two faces after the rotations.

*Face notation*  
* F (Front): the side currently facing the observer
* B (Back): the side opposite the front
* U (Up): the side above or on top of the front side
* D (Down): the side opposite the top, underneath the cube
* L (Left): the side directly to the left of the front
* R (Right): the side directly to the right of the front

*Rotation notation*  
* A rotation without the prime symbol ' is a quarter turn clockwise.
* A rotation with the prime symbol ' is a quarter turn counter-clockwise.
* x, x': rotate cube on R (R and L still face the same directions after rotation)
* y, y': rotate cube on U (U and D still face the same directions after rotation)
* z, z': rotate cube on F (F and B still face the same directions after rotation)

Example 1  
z  
D  
L  
Means: rotate cube clockwise on F and identify the new directions of D and L.  
Answer: Output L in line 1 because the initial down face now faces left. Output U in line 2 because the initial left face now faces up.

Example 2  
z z'  
U  
R  
Means: rotate cube clockwise on F then counter-clockwise on F, and identify the new directions of U and R.  
Answer: Output U in line 1 and R in line 2 because both faces do not change directions after the rotations.

# Input
* Line 1: Space-separated rotations in xyz notation.
* Line 2: Initial direction of face1 the first queried face.
* Line 3: Initial direction of face2 the second queried face.

# Output
* Line 1: Direction of face1 after the rotations.
* Line 2: Direction of face2 after the rotations.

# Constraints
* 1 ≤ length of rotations ≤ 100
