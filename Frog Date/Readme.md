# Puzzle
**Frog Date** https://www.codingame.com/contribute/view/10983981740724ab0540eb7c00c871069fa99c

# Goal
Two frogs, Frog A and Frog B, start from different points on a circular latitude line. They are both jumping westward (in the same direction) and hope to meet each other.

The latitude line they are on forms a complete circle, meaning that if either frog jumps past the westernmost point of the line, it will loop back around to the easternmost point, allowing them to keep jumping infinitely.

Frog A starts at position x, and Frog B starts at position y on this circular line. Frog A can jump a fixed distance of m meters per jump, while Frog B jumps n meters per jump. Both frogs jump once per second.

*Your task is to determine:*  
1) If the two frogs can land at the same point at the same time, and if so,  
2) The minimum number of jumps it will take for them to meet.

If they cannot meet at the same point at the same time under these conditions, you should output Impossible.

*Important Notes:*  
- The circular latitude line has a total length of L meters. Any jump that goes beyond L meters will wrap around to the starting position, maintaining the circular movement.
- Frogs can only meet if they land on the same exact point on the circle at the same time. If one frog lands at the point before or after the other, they cannot meet.
  
# Input
* Line 1: Five space-separated integers: x, y, m, n, L, where:
    * x is Frog A's starting point
    * y is Frog B's starting point
    * m is Frog A’s jump distance in meters
    * n is Frog B’s jump distance in meters
    * L is the total length of the circular latitude line

# Output
* Line 1: The minimum number of jumps required for the frogs to meet at the same point at the same time. If it is impossible for them to meet under any number of jumps, output Impossible

# Constraints
* x ≠ y
* 0 ≤ x, y < L
* 0 < m, n ≤ 2,000,000,000
* 0 < L ≤ 2,100,000,000
