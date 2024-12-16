# Puzzle
**Lazzie Come Home** https://www.codingame.com/contribute/view/101457c36421540967e67263c5d29e9a89179a

# Goal
Direct Lazzie to safely reach home.
Lazzie walks on a grid containing passable tiles and various obstacles, and can move in cardinal directions: N, S, W, E. She can't see the entire map, only a small area around her, but she remembers where, relative to her starting position, the home is. Lazzie is a very fragile being, so colliding with any obstacle results in her death.

*Victory Conditions*  
Lazzie reaches a home enterance within a test-dependent turn limit. 

*Loss Conditions*  
Lazzie steps into an obstacle.  
Number of turns exceeds test's turn limit.  
The answer is not properly formatted.  
Response time exceeds the time limit.  

*Debugging tips*  
Move map around and zoom in/out using mouse drag and wheel.  
Print more than one action (up to 10) to show visualized future path.


# Initial input
* A single line containing three space-separated integers, visionRange homeDistanceHorizontal homeDistanceVertical, where:
    * visionRange is a diameter of Lazzie's vision (always odd),
    * homeDistanceHorizontal is a distance in W/E direction towards home (negative means W side, positive means E side),
    * homeDistanceVertical is a distance in N/S direction towards home (negative means N side, positive means S side).

# Input for the following turns
* visionRange lines: a string of length visionRange, containing a row of the map within the vision range (top to bottom). Possible values:
    * L Lazzie (always present in the center tile),
    * H home entrance,
    * \. passable terain,
    * \# impassable obstacle,
    * ? outside vision circle.

# Output
* A single line containing a direction(s) where Lazzie should go: N/S/W/E. The first provided direction is applied, but more can be given to show planned path on visualization (max 10 steps is visualized).

# Constraints
* 10 ≤ map width, map height ≤ 200
* 5 ≤ visionRange ≤ 13
* Response time for first turn ≤ 1s
* Response time for the following turns ≤ 50ms
