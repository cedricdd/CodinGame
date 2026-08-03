# Puzzle
**Image Recovery Department** https://www.codingame.com/contribute/view/1508259d38553ca4273153ae30ab92e5b04982

# Goal
Your company maintains an image transfer library used by clients to transmit digital images between systems.

A bug in version 2.8 of the library caused certain square regions of an image to be rotated during decoding. Although the issue has since been fixed, thousands of images decoded using the faulty version remain corrupted.

Fortunately, every decoding session generated a diagnostic_log containing the exact sequence of transformation entries that produced the corrupted image. Since these operations are deterministic, the original image can be recovered.

Your team has been assigned to develop the recovery utility.

Given a corrupted image and its corresponding diagnostic_log, undo the transformations to reconstruct and output the original image.

Log Format:  
Each log entry consists of 4 space-separated integers.
```r c turn radius```

(r, c) specifies the coordinates of the center of the rotated square. The origin (0, 0) is located at the top-left corner of the image. The r-coordinate increases from top to bottom, and the c-coordinate increases from left to right.
turn is a signed integer with an explicit + or - sign. It indicates the number of 90° rotations applied to the square region. A positive value indicates the number of 90° clockwise rotations, while a negative value indicates the number of 90° counterclockwise rotations.
radius specifies the perpendicular distance from the center to any edge of the square region.

Square Selection Example:  
Consider the following image with h = 5 and w = 19:
```
...................
....ABC............
....DEF............
....GHI............
...................
```

Suppose the first transformation in the diagnostic_log is:
```2 5 +1 1```

This represents a rotation with:  
- center (r, c) at (2, 5)
- turn = +1 (90° clockwise)
- radius = 1

The selected square therefore contains all points with:
- r in the range 1 to 3 (inclusive)
- c in the range 4 to 6 (inclusive)

The selected 3 × 3 region:
```
ABC                  GDA
DEF    --becomes-->  HEB
GHI                  IFC
```

After applying the transformation, the complete image becomes:
```
...................
....GDA............
....HEB............
....IFC............
...................
```

ASCII art used in test cases are gathered from asciiart.eu

# Input
* Line 1: h and w, two integers separated by a space representing the height and width of the image respectively.
* Line 2: log_length, an integer representing the number of transformation entries in the diagnostic_log.
* Line 3: diagnostic_log, a string containing log_length entries separated by exactly 2 whitespaces. Each entry adheres to the log format specified above.
* Next h Lines: A string line with length w representing 1 line of the image.

# Output
* h lines: Reconstructed Image.

# Constraints
* 0 < h, w ≤ 50
* 0 < log_length ≤ 150
* -10000 ≤ turn ≤ +10000
* radius ≤ r < h - radius
* radius ≤ c < w - radius
