# Puzzle
**The Sovereign's Game** https://www.codingame.com/contribute/view/11307306c9d6081549b4e9ed20ddb4cd10b995

# Goal
You have successfully completed The Institute as Primus of House Mars and have been invited to play The Sovereign's Game. The game is designed to ensure that only the most strategic and ambitious prevail. There are n piles of resources available, and the objective is to collect the MAXIMUM number of resource points within k turns.

*Collecting Resources:*  
Each turn, you may select any one resource pile and collect ALL the resource points from that pile.

*Resource Replenishment:*  
After a resource pile has been collected, it is replenished to rate% of its current value rounded DOWN. Once a resource pile has been collected, it CANNOT be collected again until 3 turns have passed from when it was last collected.

Example: If a resource pile has value of 19 points and the rate is 10, the pile will be replenished to 1 point (19 × 10% = 1.9 rounded down to 1).

# Input
* Line 1: Integer k representing the number of turns.
* Line 2: Integer n representing the number of resource piles.
* Next n lines: Space separated integers representing resource points and replenish rate in the form: value rate

# Output
* Integer of MAXIMUM resource points collectable in k turns.

# Constraints
* 1 ≤ k ≤ 999999
* 1 ≤ n ≤ 1500
* 1 ≤ value ≤ 10000
* 0 ≤ rate ≤ 100
