# Puzzle
**Cubax Folding** https://www.codingame.com/training/hard/cubax-folding

# Goal
Woody and Buzz Lightyear are welcoming Cubax, Andy's new toy. This toy is actually a Chinese puzzle whose expected “final” state is a simple cube. During the festivities, Cubax unfolded, because it cannot move when folded.  
Suddenly, Andy appears at the window! He will be up in the room in an instant. Buzz and Woody only have a few seconds to pack Cubax back into its original package before Andy comes in and discovers his toys are alive…

Cubax is composed of N³ smaller cubes (elements) linked together in a kind of doubly linked chain. The chain has two ends, it doesn't loop.  
3 successive elements of Cubax are either:
* always aligned
* always at a right angle (90°)

Thus a simple way of defining Cubax's structure is to provide the successive number of aligned blocks, starting from the first element.

For example, representing S as the starting elements, E as the ending element and X as other elements, the structure defined as 332 could take any of the following 2D shapes:
```
  XE   EX
  X     X
SXX   SXX   SXX   SXX
              X     X
             EX     XE
```

Another example: 434 could be represented as:
```
S E
X X
X X
XXX
```

Note: Counting the successive the number of aligned elements implies that elements in an angle are counted twice. In the last example 434, there are actually only 4+3-1+4-1=9 elements.

To provide the output solution, use the following rules.  
For each series of aligned blocks, one character representing the direction where it has to point to is written:
- U Direction Up (increasing y)
- D Direction Down (decreasing y)
- R Direction Right (increasing x)
- L Direction Left (decreasing x)
- F Direction Front (increasing z)
- B Direction Back (decreasing z)
  
Considering a 3D representation (x,y,z), we will only be interested in the solutions where the first element is located at (1,1,1) and where the last element is located at (N,N,N)  
Note: As a consequence, there will be no valid solution starting by D, L or B.

Example: for the input 3332, the output RDRD corresponds to the following planar shape:
```
SXX
  X
  XXX
    E
```

For the same input 3332, the output RDLU corresponds to:
```
SXX
E X
XXX
```

Your program has to read the initial shape of Cubax and provide to Woody and Buzz the moves to apply so as to pack it back to a full cube of side length N.

# Input
* Line 1 : An integer N. The side length of the cube
* Line 2 : A string BLOCKS. Each character providing the successive number of aligned blocks

# Output
* The alphabetically-sorted list of all solutions, one solution per line

# Constraints
* 2 ≤ N ≤ 4
* SUM ( BLOCKS[i] - 1 ) = N³ - 1
* 2 ≤ BLOCKS[i] ≤ N
