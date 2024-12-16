# Puzzle
**Jumping Frogs** https://www.codingame.com/training/medium/jumping-frogs

# Goal
There are three frogs sitting on a two-dimensional plane. The ith frog starts at coordinates xi, yi. Whenever the ith frog jumps, it jumps in such a way that each of its coordinates either remains unchanged or it changes by exactly ki. If all three frogs can eventually meet at the same coordinates, print "Possible". Otherwise, print "Impossible".  

*Jumping example:*  
If a frog is at (4,0) and its jumping distance (k) is 2. Then during the next step the frog can be at one of the nine positions: (4,0), (4,2), (4,-2), (6,0), (6,2), (6,-2), (2,0), (2, 2), (2,-2).

# Input
* Line 1: Three space-separated integers x1, y1 and k1.
* Line 2: Three space-separated integers x2, y2 and k2.
* Line 3: Three space-separated integers x3, y3 and k3.

# Output
* For each test case, print "Possible" if all 3 frogs can eventually meet, "Impossible" otherwise.

# Constraints
* -10000 ≤ xi,yi ≤ 10000
* 1 ≤ ki ≤ 100
* All 3 frogs start at different locations.
