# Puzzle
**Seam Carving** https://www.codingame.com/training/medium/seam-carving

# Goal
Seam carving is a content-aware image resizing technique that often leads to impressive results despite being very simple. When used to reduce the size of an image, it intends to remove the supposedly least significant parts of the image instead of resizing everything in a uniform manner.  
In this problem, we implement the main algorithm behind seam carving. To focus on the algorithmic aspects, we only reduce the width of grayscale images.  

Given a grayscale image of size W×H, let I(x,y) be the 1-byte intensity (from 0 for black to 255 for white) of the pixel at (x,y) with 0 ≤ x < W and 0 ≤ y < H; (0,0) being the top-left corner of the image. We define the intensity differentials and the energy function as:
```
dI/dx(x,y) = I(x+1,y) - I(x-1,y) if 0 < x < W-1
             0                   otherwise (left/right borders)
dI/dy(x,y) = I(x,y+1) - I(x,y-1) if 0 < y < H-1
             0                   otherwise (top/bottom borders)
E(x,y) = |dI/dx(x,y)| + |dI/dy(x,y)|
         (where |.| denotes the absolute value)
```

A vertical path is a sequence of pixels (x(0),0), (x(1),1), ..., (x(H-1),H-1) such that |x(i+1) - x(i)|≤1. In other words, the path contains exactly one pixel per line and consecutive pixels are vertically or diagonally neighbors. The energy of a path is the sum of the energies of its pixels.

To reduce the width of the image by one pixel, compute a vertical path of lowest energy and simply remove it.  
To reduce by several pixels, simply repeat that 1-px reduction step on the successive reduced versions of the image.  

*Instructions*  
Given a PGM image (see input description) and its desired new width, resize it using seam carving.  
When there are several paths of lowest energy, remove the lexicographically smallest one over the (x(0), x(1), ...) values (i.e. the leftmost path from top to bottom).  
Due to the limitations on the output size, you are not asked to return the resulting image but the energies of the successively deleted paths.  

*Additional remarks*  
Try it on your own images and visualize the results! You might have to relax your PGM parser as the specifications of the format do not actually make the space/newline distinction. For very large images, make sure that you use an efficient algorithm and optimize your code so that it keeps and updates the intermediate results after each path deletion (to avoid of recomputing everything at each step).

Check out the references for more information (alternative energy functions, strategies to resize both horizontally and vertically, use seam carving to enlarge images, etc).

# Input
* The input is a valid PGM-ASCII file.
* Line 1 always contains the magic number P2 (indicating an ASCII graymap).
* Line 2: Two space-separated integers W and H corresponding to the width and height of the image.
* Line 3: The character # (to start a comment line in the PGM file) followed by a space and an integer V indicating the target width.
* Line 4 always contains 255, indicating that the intensity is coded on one byte by an integer between 0 and 255.
* Next H lines: W space-separated integers between 0 and 255 corresponding to the intensities of the pixels of the successive lines of the image (from top to bottom).

See also https://en.wikipedia.org/wiki/Netpbm_format for more information about this format.

# Output
* W-V lines indicating the energies of the successively deleted paths.

# Constraints
* 5 ≤ W, H < 100
* 3 ≤ V < W
