# Puzzle
**Static Equilibrium** https://www.codingame.com/contribute/view/134886a1467b44cd36bccace7cef8fc3771021

# Goal
This problem aims to find a single force that can put a point mass in motion to a static equilibrium in a two-dimensional space.

A point mass is in static equilibrium if the resultant forces in both the x and y directions are zero.

You are given a list of forces, each described by a magnitude and a direction. Each force acts along one of the four cardinal directions:
- RIGHT → positive x-direction
- LEFT → negative x-direction
- UP → positive y-direction
- DOWN → negative y-direction

Your task is to find the magnitude of the force that will balance all the given forces, as well as its angle measured anti-clockwise from the positive x-axis (RIGHT).

Here is a step-by-step guide:
1. Sum all forces in the x-direction (forces labelled LEFT and RIGHT). Assign negative values to forces acting in the negative x-direction (LEFT). Call this sum Fx.
2. Sum all forces in the y-direction (forces labelled UP and DOWN). Assign negative values to forces acting in the negative y-direction (DOWN). Call this sum Fy.
3. To find the components of the balancing force that will bring the point mass into equilibrium, multiply Fx and Fy by -1. These new values are your balancing force components, i.e. x = -Fx and y = -Fy .
4. Calculate the magnitude of this balancing force using the formula, corrected to the nearest hundredth. For example: 5.3659 ==> 5.37.
result = square root of ( x squared + y squared )
5. Determine the angle theta, measured anti-clockwise from the positive x-axis (RIGHT).

Use the table below to compute theta, corrected to two decimal places:
```
 x & y conditions   | Formula to find theta
 x ≥ 0, y = 0       | theta = 0°
 x = 0, y > 0       | theta = 90°
 x < 0, y = 0       | theta = 180°
 x = 0, y < 0       | theta = 270°
 x > 0, y > 0       | theta = arctan(y / x)
 x < 0, y > 0       | theta = 180° - arctan(y / |x|)
 x < 0, y < 0       | theta = 180° + arctan(|y| / |x|)
 x > 0, y < 0       | theta = 360° - arctan(|y| / x)
```

Note: |x| denotes the absolute value of x. This notation turns a negative number positive and keeps a positive number the same. For example, |-5| = 5 and |5| = 5.

If both x and y are zero, return 0.00 for both result and theta.

Example (refer to test case 1)  
1. We will proceed by summing all the forces according to their directions:  
Fx = 45 - 20 = 25  
Fy = 30 - 40 = -10  

2. Calculate x and y:  
x = -Fx = -25  
y = -Fy = +10  

3. Calculate the magnitude of the balancing force:  
Balancing Force = sqrt[(-25)^2+10^2] = 26.93

4. Calculate the angle of the force:  
As x is negative and y is positive, theta = 180° - arctan(10 / |-25|) = 158.20

# Input
* Line 1: An integer n, for the number of forces.
* Next n lines: Magnitude of the force F (integer), and the direction the force is acting dir (string), separated by a space.

# Output
* Line 1: The balancing force, result, corrected to two decimal places.
* Line 2: The angle of the balancing force theta in degrees, measured anti-clockwise from the positive x-axis (RIGHT), corrected to two decimal places.

# Constraints
* 1 ≤ n ≤ 1000
* 1 ≤ F ≤ 1000000
* The direction dir of the input can only be UP, DOWN, LEFT or RIGHT.
