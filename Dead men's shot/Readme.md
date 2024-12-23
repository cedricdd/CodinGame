# Puzzle
**Dead men's shot** https://www.codingame.com/training/easy/dead-mens-shot

# Goal
Captain Jack Sparrow and his pirate friends have been drinking one night. After plenty of rum, they got into an argument about who is the best shot. Captain Jack takes up some paint and paints a target on a nearby wall. The pirates take out their guns and start shooting.

Your task is to help the drunk pirates find out which shots hit the target.

Captain Jack Sparrow drew the target by drawing N lines. The lines form a convex shape defined by N corners. A convex shape has all internal angles less than 180 degrees. For example, all internal angles in a square are 90 degrees.

A shot within the convex shape or on one of the lines is considered a hit.

# Input
* Line 1: An integer N for the number of corners.
* Next N lines: Two space-separated integers x and y for the coordinates of a corner. The corners are listed in a counterclockwise manner. The target is formed by connecting the corners together with lines and connecting the last corner with the first one.
* Line N+1: An integer M for the number of shots.
* Next M lines: Two space-separated integers x and y for the coordinates of each shot.

# Output
* M lines with either "hit" or "miss" depending on whether the shot hit the target or not.

# Constraints
* 3 ≤ N ≤ 10
* 1 ≤ M ≤ 10
* -10000 < x,y < 10000
