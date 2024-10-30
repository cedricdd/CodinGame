# Puzzle
**Coastline** https://www.codingame.com/training/medium/coastline

# Goal
We have a long coast facing the ocean. Near the coast there are islets or rocks emerging out of water, posing threats to sea vessels.  
We plan to install signal lights and sensor instruments on the islets, powered by solar energy, to enhance sail safety. It could also provide data for weather and current forecast.   
Ideally, we wish all the off-shore instruments be network connected via a number of mobile data transmitters to be installed along the coastline.  

# Data model
To ease modelling, assume the coast is a straight line and is infinitely long for our calculation purpose.  
We are using Cartesian coordinates system, defining the coastline as the x-axis. South of the line is land. North of it is water.  
The islets locations are given by (x,y) coordinates.  
Mobile data transmitters have a fixed effective radius, r. If we use a transmitter as the center to draw a circle with radius r, the area of the circle is the effective data coverage of the transmitter.  
The distance between transmitters is not an issue because they are connected by cables. However, an islet has to be within the radius r of at least one transmitter to enable connection.  
To cover all islets within data range, we would need one or more transmitters to be installed alone the coast.  

# Problem
Given the locations of all islets together with the effective radius of transmitters, find out the minimum number of transmitters needed to be installed, if we want all islets be covered within range.

# Input
* There are multiple test cases for each test set. Each test set has the following structure.
* Line 1: Integer n for the number of lines to follow.
* The following n lines: Each line is an independent test case, having a number of space-separated integers: p r x1 y1 x2 y2 ... xp yp

Where p is an integer, for the number of islet points in the test;
r is an integer, for the radius of transmitter data range;
Then followed by p pairs of integers, x and y, each pair for one islet point's coordinates.

There is no duplicate coordinates in each test case.

# Output
* n lines: Each line is an integer for the minimum number of coastline transmitters necessary to cover all islets points in the corresponding test case.
* In case it is not possible to cover all given islets within range, output -1 to indicate an exception.

# Constraints
* 1 ≤ n ≤ 50
* 1 ≤ p ≤ 100
* 1 ≤ r ≤ 1000
* -1000 ≤ x ≤ 1000
* 1 ≤ y ≤ 1000
 
