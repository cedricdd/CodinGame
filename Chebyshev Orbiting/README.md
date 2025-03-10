# Puzzle
**Chebyshev Orbiting** https://www.codingame.com/training/medium/chebyshev-orbiting

# Goal
Spaceship is orbiting the planet in the Discrete Chebyshev 2D Space. By given initial spaceship position and velocity predict its position after time seconds.

# Physics
Planet has its center in (0, 0). All points with Chebyshev distance to planet center less then or equal to radius, belongs to planet.   
Chebyshev distance between (x1, y1) and (x2, y2) is Max(Abs(x1 - x2), Abs(y1 - y2))  

*Spaceship works as follows:*  
1. Every turn spaceship moves if it is not crashed yet: velocity vector is added to ship position.
2. Spaceship crashed if its final position has chebyshev distance to planet center less then or equal to radius.
3. Chebyshev gravity is applied. Denote ship position as (x, y) and velocity as (vx vy).

Then vx is decreased by 1 if x > 0 and increased by 1 if x < 0. And vy is decreased by 1 if y > 0 and increased by 1 if y < 0.

*Sample*  
Spaceship coordinates sequence after simulation for planet radius 1 and start velocity (2, 0):
```
(0; −3) → (2; −3) → (3; −2) → (3; 0) → (2; 2) → (0; 3) → (−2; 3) → (−3; 2) → (−3; 0) → (−2; −2) → ...
```

See image with this trajectory below.
```
.........
....0.1..
..9....2.
...PPP...
.8.PPP.3.
...PPP...
.7....4..
..6.5....
.........
```

# Input
* Single line with 6 spaces separated integers: radius, x, y, vx, vy, time

# Output
* Single line with 3 spaces separated integers: x y crashed
* Crashed is 1 if spaceship is crashed in the planet and 0 otherwise.

# Constraints
* -50 ≤ x, y, vx, vy ≤ 50
* 0 ≤ radius ≤ 10
* 0 ≤ time ≤ 1000000000
