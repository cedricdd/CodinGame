# Puzzle
**Stall tilt** https://www.codingame.com/training/easy/stall-tilt

# Goal
During motorcycle competitions, the speeds achieved are incredible. But this speed is often the cause of accidents, especially in bends.   
Indeed, when entering a bend, the motorcycle undergoes the centrifugal force that drives the motorcycle out of the bend.   
To combat this, riders use a technique called "centripetal tilt" which consists in tilting the bike towards the inside of the bend to compensate for this force.   
This technique reaches its limits when the speed is too high, which can lead to slippages that lead to falls. Hence the importance of controlling your speed ;)  

The purpose of this puzzle is to define the maximum constant speed that your bike must have to pass all the bends of the circuit without stalling and while being the first in the competition.   
In addition, your job will be to develop the ranking for this competition.

The ranking of this competition is done in this way:  
V=Speed  
- If Va>Vb>Vc then "a" first, "b" second, "c" third.
- If Va>Vb>Vc and "a" falls then "b" first, "c" second, "a" third
- If Va>Vb>Vc and "b" falls at bend 2 and "a" at bend 5 then "c" first, "a" second, "b" third
- If Va>Vb>Vc and "b" falls at the same bend as "a" then "c" first, "a" second, "b" third  
In the final ranking, you are also counted and represented by the letter "y" (as the goal of this puzzle is that you are the optimal speed you will always be in the first position).

Finally, to know the angle for vertical relation you will need this:
```
tan(θ) = v² / (r × g)
```
v = speed (m/s) / r = radius of the bend (m) / g = 9.81 (m/s²) / θ = angle with respect to the vertical (degrees)  
A motorcycle will stall if the angle to the ground is < 30 degrees.

# Input
* First line: Number n of motorcycles (other than yours) participating in the competition.
* Second line: Number v of curves in the circuit.
* Next n lines: The constant speed of each motorcycle (The first speed of the list given by the loop is that of competitor a, the second that of competitor b...) (m/s).
* Next v lines: The radius of each curve of the circuit (m).

# Output
* First line: The maximum constant speed to avoid stalling in the circuit.
* Last n+1 lines: The ranking of the competition.

# Constraints
* 0 < n, v < 13
* 0 < speed < 70
* 0 < r < 200
* The output angles are always integers
