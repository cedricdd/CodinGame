# Puzzle
**3D printer** https://www.codingame.com/training/medium/3d-printer

# Goal
You get 3 pictures made by # in sizes width*height, length*height and width*length. The first one is the front view, the second one is the view from the right side and the third one is the view from the top. You need to print the 3D model based on the pictures you get; one by one layer separated by two dashes from bottom to the top layer and two dashes at the end.

*Example Input*  
```
2    // width
5    // height
1    // length
##   // start of front view, always height number of lines
##
##
##
##
#    // start of right side view, always height number of lines
#
#
#
#
##    // start of top view, always length number of lines
```

So from these inputs, your code should guess what is the 3D model. In the example it's a block 2x5x1.

*Example Solution*  
```
##    // the lowest layer
--
##
--
##
--
##
--
##    // the highest layer
--
```

If the three pictures cannot define some parts of the model as solid or hollow, assume these parts are solid, so that output '#' to fill-in.

# Input
* Line 1: An integer width of the 3D model
* Line 2: An integer height of the 3D model
* Line 3: An integer length of the 3D model
* Next height lines: Strings - part of the front view
* Next height lines: Strings - part of the view from the right
* Next length lines: Strings - part of the view from the top

NOTE There is no trailing space in the input.

# Output
* Layers of the 3D model separated by two dashes and two dashes at the end.
* Write no trailing space in output.
* If the three pictures cannot define some parts of the model as solid or hollow, assume these parts are solid, so that output '#' to fill-in.

# Constraints
* 0 < width, height, length ≤ 20
