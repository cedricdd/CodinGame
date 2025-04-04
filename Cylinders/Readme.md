# Puzzle
**Cylinders** https://www.codingame.com/training/medium/cylinders

# Goal
I have a bunch of cylinders of various diameters needing to pack in a box. All cylinders must lay flat in the box without stacking over the others.   
It was found that by arranging the cylinders in different orders, the total width of the cylinders can be different.

The diagram in the banner shows an example how nine cylinders (radii from 1 to 9) can be tightly packed.  

Given an array of cylinders, find out how small the box can be to best fit all cylinders properly.

# Input
* There are multiple tests in each test case.
* Line 1: An integer n for the number of tests.
* The following n lines: Each line is an independent test. A line starts with integer m, for the number of cylinders, followed by m integers, for the radius of each cylinder. The numbers are space separated with the radii in no special order.

All cylinders have the same height. You do not need to care about it. You just need to consider how all the cylinders can be packed together tightly to the minimum width by factoring in the radii only.

# Output
* Write n lines : Corresponding to each input line, output the minimum width of the box good enough to put all these cylinders in.
* The output has to be decimal numbers, with 3 places after the decimal point. For example, value of 3.14159 has to be rounded to 3.142. Value of 3.1414 should be written as 3.141. Value of 3 should be written as 3.000
* All given radii and your output are assumed to be using the same unit.

# Constraints
* 1 ≤ n ≤ 10
* 1 ≤ m ≤ 9
* 1 ≤ each radius ≤ 10000
