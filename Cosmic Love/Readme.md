# Puzzle 
**Cosmic Love** https://www.codingame.com/training/easy/cosmic-love

# Goal
««Prompt»»  
Gary is attracted to Alice. It is almost as if there is some mysterious force pulling them together.   
However, Alice is known for viciously tearing apart potential suitors that get too close.   
In fact, Alice is currently undergoing such a temper tantrum, and Gary must get away immediately lest he be torn asunder!   
Help Gary find the closest planet to land his spaceship on that will not be ripped apart by Alice's gravitational field.  

««Details»»  
N planets, including Alice, are listed with names name, radii r, masses m, and current distances c from Alice.   
The Roche Limit between a planet and Alice defines the distance below which a planet would disintegrate due to Alice's gravitational field.   
Determine the closest of the N planets that will not disintegrate.  

««Math»»  
Some equations reminiscent of high school physics:  
    Alice's Roche Limit = rA * cube-root ( 2 * dA / dP )  
        where rA is the radius of Alice,  
        dA and dP are the densities of Alice and a planet.  
    Volume of sphere V = 4/3 * pi * r^3  
    Density d = m / V  

Model each planet as a sphere of uniform density. Distances are measured between centers of the spheres.   
For simplicity's sake for defining the "closest" planet, assume that all celestial bodies are positioned in a line, with Alice and Gary at one end of the line.

««Disclaimer»»  
This puzzle does not reflect reality and should be kept away from children under the age of 90.   
If you experience strange sensations of being ripped apart from within after solving this puzzle, call your doctor right away.

# Input
* Line 1: An integer N representing the number of planets, including Alice
* Next N lines: Space separated strings name, r, m, and c, describing a planet.
   * Radii and orbital distances are given in units of m
   * Masses are given in units of kg
   * Quantities are formatted in scientific notation: 0.00e00. For example, 8.00e3 represents 8,000, and 1.63e10 represents 16,300,000,000.
    
# Output
* The name of the closest planet to Alice that will remain intact

# Constraints
* 2 ≤ N ≤ 30
* 1e0 ≤ r,m,c ≤ 1e50
* 1 ≤ length of a name ≤ 30
* names consist of characters A-Za-z0-9_
* Each test case has one unique solution
