# Puzzle
**The Infinite Grid** https://www.codingame.com/contribute/view/1155156b169c7f8a751cff89e8a88d859ebb54

# Goal
All positive integers are arranged in an infinite 2D grid in a specific spiral pattern. The grid begins with 1 in the top-left corner and expands outward as shown:

````
 1     4      5     16     ...
 2     3      6     15     ...
 9     8      7     14     ...
10     11    12     13     ...
...
````

Given a number n, calculate the numbers directly adjacent to n above, below, to the left, and to the right. If an adjacent number does not exist (e.g., n is on the edge of the grid), output a hyphen - for that position.

The output should be a single string of numbers separated by commas, in the order: top, bottom, left, right.

# Input
* Line 1: A single integer n

# Output
* Line 1: The adjacent numbers

# Constraints
* 1 ≤ n ≤ 10^8
