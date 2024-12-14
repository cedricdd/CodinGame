# Puzzle
**Introduction to Skylines** https://www.codingame.com/contribute/view/903717edf881d7426bd8744850705bc3f2291

# Goal
Draw the skyline of a city in Ascii Art

After a great day of programming, you go on the top of a hill to relax and admire the beautiful sunset on your city...

But a programmer cannot shut off his brain. So you wonder... If someone gives you 2D coordinates of the buildings on the horizon, would you be able to draw the city's skyline ?

Each building is described by its height (h) above ground level and the horizontal position of the left (x1) and right (x2) walls.

Buildings can overlap like this:
```
 ____
|    |____
|  ¦¨¦    |
|  ¦ ¦    |
```

In this case, you shouldn't draw overlapping parts as they are undistinguishable in the sunset.
```
 ____               ____
|    |             |    |
|    |____    ->   |    |____
|  ¦¨¦    |        |         |
|  ¦ ¦    |        |         |
```


In this example, the block on the right is made up of three buildings:
```
 ___
|   |        ___
|   |   ____|   |
|   |  |        |_
|   |  |          |
|   |__|          |
```

Ground level should be drawn if needed.  
Your skyline should start at the first building and end at the last building. No need to draw ground level before and after these buildings.

Thanks @Heino for the inspiration to create this puzzle. (https://www.codingame.com/training/expert/skylines)

# Input
* Line 1: An integer n for the number of buildings in the city.  
* Next n lines: Three space separated integers h, x1 and x2.

The buildings are given in no particular order.

# Output
* Ascii Art Skyline
* Unnecessary whitespace should be removed.

# Constraints
* 1 ≤ n ≤ 100
* 1 ≤ h ≤ 15
* 0 ≤ x1 < x2 ≤ 200
