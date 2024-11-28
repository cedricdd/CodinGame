# Puzzle
**Fractal Image Recognition** https://www.codingame.com/training/medium/fractal-image-recognition

# Goal
These fractals are more similar to those of Bill Williams, which are used in price chart analysis, rather than fractals of Benoit Mandelbrot.

Place fractals around extremums of the image.  
An extremum is a pixel P that is filled ("1") and has at least 5 consecutive empty ("0") spaces around it.

East fractal is represented by "2"  
North = "3"  
North-east = "4"  
North-west = "5"  
South = "6"  
South-east = "7"  
South-west = "8"  
West = "9"  

To place a fractal to the north ("3") of pixel P, pixels "9", "5", "3", "4", "2" around pixel P must be empty.  
To place a fractal to the northeast ("4") of pixel P, pixels "5", "3", "4", "2", "7" around pixel P must be empty.

# Input
* An integer imageSize for the width and height of the square image.
* Next imageSize lines: strings of 1 and 0 pixels, space separated.

# Output
* imageSize lines: strings containing pixels and fractals, space separated.

# Constraints
* imageSize = 10
* Each pixel color is "0" or "1"
