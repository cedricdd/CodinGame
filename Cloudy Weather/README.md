# Puzzle
**Cloudy Weather** https://www.codingame.com/training/hard/cloudy-weather

# Goal
During its last expedition, the solar-powered robot CG-713705 got into a little trouble:  
Its batteries broke down after a general overheat due to the compulsive computation of the decimals of π  
the robot launches each time it is bored roaming long distances before reaching its mission location.  

The batteries are now completely out of order and the robot can only rely on the instantaneous output of its solar panels to provide energy.  
Unfortunately a misfortune never comes alone and the weather is getting cloudy!  
Thanks to its satellite connection, the robot has collected the positions of the clouds in the surrounding area in order to plan its trip back to the base.  
Each cloud projects a rectangular shadow on the ground that the robot must absolutely avoid. There is no wind: The clouds do not move.  

We use the following convention: the x-axis goes right, the y-axis goes down, (0,0) is the top-left corner of the map.  

The robot is currently at (Xs,Ys) and must reach the base at (Xd,Yd) for maintenance.  
The robot occupies exactly one unit square: When at position (x,y), it covers the square [x, x+1] × [y, y+1].  
It takes one step to move one unit horizontally or vertically (said otherwise, we consider the Manhattan or taxicab distance).  

Help the robot compute the minimum distance from its current location to the base.  

Note however that, clouds being clouds, they can be huge.
Examples: First two maps (# the shadows, Sxx...xD a shortest path, minim  um distance is 17 in both cases).
```
 ┌──────────── X     ┌─────────────────── X
 │............        │...................
 │..D.....###.        │..Dxxxx########....
 │..x.....###.        │...###x########....
 │..x.....###.        │...###x########....
 │..x.#######.        │...###x########....
 │..x.#######.        │...###x########....
 │..x.#######.        │...###x########....
 │..xx........        │...###x............
 │..#x........        │...###xxxxxxS......
 │..#x.....##.        │...###.............
 │..#x.....##.        │...###..##########.
 │..#x.....##.        │...###..##########.
 │..#xxxxxS##.        │....##..##########.
 │..#......##.        │....##..##########.
 │..#.........        │....##..##########.
 │............        │....##..##########.
 Y                    │....##.............
                      │...................
                      Y
```

# Input
* Line 1: Two space-separated integers Xs and Ys indicating the starting position.
* Line 2: Two space-separated integers Xd and Yd indicating the destination.
* Line 3: An integer N indicating the number of clouds to follow.
* Next N lines: Four space-separated integers Xi, Yi, Wi and Hi indicating respectively the top-left corner coordinates of the shadow of a cloud, its width and height: The shadow covers the rectangle [ Xi, Xi+Wi ] × [ Yi, Yi+Hi ].

# Output
* One single integer corresponding to the minimum distance between (Xs,Ys) and (Xd,Yd).

# Constraints
* 1 ≤ N ≤ 250
* 0 ≤ Xs, Ys, Xd, Yd, Xi, Yi < 10^9
* 0 < Wi, Hi < 10^9

Shadows can overlap.  
Distances fit in 32-bit unsigned integers.  
Starting position and destination are sunny places.  
The map has no borders: The robot is allowed move to any coordinates -∞ < x,y < ∞ provided there is a sunny path that leads there.  
Any position that is not explicitly covered by the shadow of a cloud should be considered sunny.  
