# Puzzle
**In Stereo** https://www.codingame.com/training/easy/in-stereo

# Goal
A time machine with an empty gas tank leaves you stranded in a 1990s shopping mall, with nothing the locals recognize as money.   
The only commodity you can release without ruining the timeline are those stereogram posters sometimes known by the trade name "Magic Eye".   
Can you sell enough 3D art to top up the tank and get back to modern life?  

https://en.wikipedia.org/wiki/Autostereogram

Start with a base pattern (which wraps around), a stock of extra symbols to fill in when the pattern needs to grow, and a depth map.

For each line in the depth map, start at the beginning of the original pattern with the original stock and at a depth of 0.

For each character in the depth map:  
1. If the depth is higher, decrease the pattern by removing characters at the current position.
If the depth is lower, increase the pattern by moving characters from the stock into the current position.
2. Output the pattern character at the current position.
3. Advance to the next pattern position, wrapping around if you reach the end.

For example, if the pattern is ABCD, the stock is UVWX, and the depth map is 23200:
```
        | Current | New   | Change   |          | New     |       |
Pattern | Depth   | Depth | in Depth | Action   | pattern | Stock | Output
--------+---------+-------+----------+----------+---------+-------+-------
ABCD    | 0       | 2     | +2       | Remove 2 | CD      | UVWX  | C
CD      | 2       | 3     | +1       | Remove 1 | C       | UVWX  | C
C       | 3       | 2     | -1       | Add 1    | UC      | VWX   | U
UC      | 2       | 0     | -2       | Add 2    | UVWC    | X     | V
UVWC    | 0       | 0     | 0        | Nothing  | UVWC    | X     | W
```

Because of length limitations for test cases, the examples below are too narrow to see easily.  
Here's a wider depth map: https://pastebin.com/raw/ZBffbNTy  
The stereogram it produces: https://pastebin.com/raw/UZbLA2CE  
(Zoom out until the lines do not wrap. Use the parallel "wall-eyed" viewing technique, not cross-eyed.)  

# Input
* Line 1: An integer P for the length of the pattern
* Line 2: A string pattern
* Line 3: An integer S for the length of the stock
* Line 4: A string stock
* Line 5: Two integers H W for the height and width of the depth map
* Next H lines: A string of length W for each line of the depth map

# Output
* H lines of width W: The stereogram

# Constraints
* P < 20
* S < 20
* H < 30
* W < 200
