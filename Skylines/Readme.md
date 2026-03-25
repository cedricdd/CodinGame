# Puzzle
**Skylines** https://www.codingame.com/training/expert/skylines

# Goal
Count the number of lines needed to draw the skyline of a city.

The city skyline (or silhouette) as seen from a distance consists of a series of buildings with rectangular shape which might overlap each other.  
Each building is described by its height (h) above ground level and the horizontal position of the left (x1) and right (x2) walls.  

Line drawing rules:  
To draw the skyline of a city with a single building 3 lines are required: One for the left wall, one for the roof and one for the right wall.
```
      ____
     |    |
     |    |
     |    |
```

Two separate buildings can be drawn using 7 lines: 3 lines for each of the two buildings and one line connecting the buildings on ground level.
```
      ____
     |    |      ______
     |    |     |      |
     |    |_____|      |
```

Two partially overlapping or adjacent buildings of different heights require 5 lines to be drawn. One for the left wall of the first building, two for the roofs, one for the wall connecting the roofs and one for the right wall of the second building.  
The dotted lines in the picture below show the actual shape of the two buildings.
```
      ____
     |    |____
     |  ¦¨¦    |
     |  ¦ ¦    |
```

Two buildings are called adjacent (i.e. touching each other) if their opposing walls have the same horizontal position.

# Input
* Line 1: An integer n for the number of buildings in the city.
* Next n lines: Three space separated integers h, x1 and x2 for the height and the two positions of the walls respectively.
* The buildings are given in no particular order.

# Output
* One line containing the number of lines needed to draw the city skyline.

# Constraints
* 1 ≤ n ≤ 100
* 1 ≤ h ≤ 200
* 0 ≤ x1 < x2 ≤ 5000
