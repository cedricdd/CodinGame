# Puzzle
**Inequality Overlap Area** https://www.codingame.com/training/medium/inequality-overlap-area

# Goal
Given n, the number of inequalities that will be given, and the inequalities in the form ax (+/-) by (<=/>=) c, find if all the inequalities overlap in the same place and the area of the overlap.

Here are the three possibilities:
1) All the inequalities overlap in the same place, and the overlap area is finite, so output the overlap area.
2) Not all the inequalities overlap in the same place, so just output No Overlap.
3) All the inequalities overlap in the same place, but the overlap area is infinite, so just output Overlap, But Infinite.

Here is an example for all three possibilities: https://imgur.com/a/V5D90gI

Note: If all the inequalities overlap on a point or line, it counts as a No Overlap.

# Input
* Line 1: An integer n.
* Next n Lines: A string s, for an inequality in the form ax (+/-) by (<=/>=) c where a, b, and c are floats.

# Output
- No Overlap if not all the inequalities overlap in the same place
- Overlap, But Infinite if all the inequalities overlap in the same place, but the overlap area is infinite.
- The area of the overlapped place rounded to the nearest thousandths if all the inequalities overlap in the same place, and the overlap area is finite.

Note: The output has to contain 3 decimal places.

# Constraints
* 2 ≤ n ≤ 20
* 0 ≤ |a|, |b|, |c| ≤ 1000
* 12 ≤ length of s ≤ 30
