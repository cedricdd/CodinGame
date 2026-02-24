# Puzzle
**Ballistic Trajectory** https://www.codingame.com/contribute/view/143400351b88920a0196bb98da8a199e034f07

# Goal
A cannonball is fired from the ground with an initial speed V0 at an angle theta.

The horizontal and vertical motions are independent :
- Horizontal = constant velocity (no acceleration)
- Vertical = constant acceleration (gravity only)
- g = 9.80665 m/s²

The projectile lands when it reaches the ground (y = 0, t > 0).  
A target is placed at a horizontal distance D from the launch point.  

Given V0, theta and D, determine if the projectile lands within 0.5m of the target.  
Print HIT or MISS <error> where error = R - D.  
rounded to 2 decimal places (signed).  

You can check more about trajectory here: https://byjus.com/trajectory-formula/

# Input
* Line 1 : V0 theta D
  - V0 = initial speed (float, m/s)
  - theta = launch angle (float, degrees, 0 < theta < 90)
  - D = target distance (float, meters)

# Output
* If the projectile lands within 0.5m of the target: HIT
* Otherwise: MISS <error> where <error> = R - D rounded to 2 decimal places (signed)

# Constraints
* 1 ≤ V0 ≤ 200
* 1 ≤ theta ≤ 89
* 1 ≤ D ≤ 5000
