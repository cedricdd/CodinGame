# Puzzle
**Smile! Frieze! Cheese!** https://www.codingame.com/training/medium/smile-frieze-cheese

# Goal
If you try to fill a ribbon with a repetitive pattern, you will only find seven unique ways to do it due to symmetry.  
The names of these symmetry classes (Frieze groups) are provided below with examples. Each class of patterns may include horizontal and vertical symmetries, 180° rotations, and glide-reflections. All patterns also include horizontal translations, they are omitted below.

* p111: RRRRR No other transformations.
* p1m1: DDDDDD A horizontal symmetry.
* pm11: MMMMMM Vertical symmetries.
* p112: SSSSSS Only rotations.
* pmm2: HHHHHH Horizontal and vertical symmetries and rotations.
* p1a1: pbpbpb Only glide-reflections.
* pma2: A∀A∀A∀ All transformations excepted horizontal symmetries.

You will be given a pattern in ASCII and you will have to find the mathematical name of the frieze.  
Note that you will be given a full pattern, it won't be cut.  

# Input
* Line 1: The number n of lines of the pattern below
* Next n lines: The pattern you have to name

# Output
* The name of the pattern

# Constraints
* The pattern will contain only hyphens - and hashes #.
* Note that you will be given a full pattern and the full pattern is given without any truncation.
