# Puzzle
**Simple Blur** https://www.codingame.com/training/medium/simple-blur

# Goal
Take a data representation of an image and blur it by averaging each pixel's color with its neighbors above, below, and to the left and right of it.

*Rules:*  
The average value should be the arithmetic mean, that is, all the values you are combining, divided by the number of values.

If the outcome of an average operation is not an integer, round it down.

Each pixel should be blurred using five pixels: itself, and its four neighbors (above, below, left, and right).   
The exception is edge and corner pixels, which will use themselves and their three/two neighbors respectively. 

# Input
* A 2-dimensional grid of pixels, with each pixel defined by its red, green, and blue values.
* The first line of input gives the size of the grid, in rows and columns respectively.
* Each subsequent line contains a pixel's RGB values in a space-separated list. The pixels are given in left-to-right, top-to-bottom order.

# Output
* Output the transformed image, one pixel per line. Each pixel will be expressed as a space-separated list of the pixel's RGB values.

# Constraints
* Each color value will be an integer in the range 0 ≤ r,g,b ≤ 255.
* Each dimension of the image grid will be an integer in the range 1 ≤ rows,cols ≤ 15.
