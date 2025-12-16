# Puzzle
**Erode an image** https://www.codingame.com/contribute/view/139671f3745fdc4c7a1f6bd3a3d8bea32d4654

# Goal
You are given an image (a grid), sized l*L filled with . (point) or # (pixel). You need to erode this image n time, that is, delete all the pixels who haven't four neighbors (don't count diagonals) n times.  

# Input
* Line 1 : One integer nbSteps, the number of steps of erosion
* Line 2 : Two space-separed integers l and L, the size of the image.
* Next l lines : L characters : . for a clear pixel and # for a black pixel. That represent the image.

# Output
* The image eroded n times.

# Constraints
* 0 < nbSteps <= 1000
* 0 < l, L < 50
* The image is filled with . or #.
