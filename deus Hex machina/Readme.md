# Puzzle
**deus Hex machina** https://www.codingame.com/training/easy/deus-hex-machina

# Goal
When written with seven-segment display (Cf. banner image), a hexadecimal digit may still read when flipped vertically or horizontally.   
What is the result of applying a sequence of horizontal and/or vertical flip instructions to a given hexadecimal number?  

- The sequence of flips is the number itself, but expressed in binary: 0 stands for horizontal and 1 for vertical.
- If the result is not a valid hex number, print Not a number.
- Should the result exceed 1000 hex digits, display only the initial 1000.
- Leading zeros in input and/or output are ok.

Below is how 123456789abcdef0 looks like after one flip:
```
Horizontal flip:    123456789abcdef0  |  0#9b#d6e8#a2##51
                  -------------------
Vertical flip:      153#2e#8a9#c#6#0
```

The # symbol above means arbitrary shapes that don't look like a valid hex digit.

Example: Let the hex number be 15 (0x15). Converting 0x15 to bin gives 10101 (0b10101).  
The flipping sequence is therefore: vertical → horizontal → vertical → horizontal → vertical.
```
   15
  ----
   12   |   51
           ----
            21   |   15
                    ----
                     12
```

# Input
* The hexadecimal number to flip, written using the characters 123456789abcdef0

# Output
* The obtained hexadecimal (up to 1000 hex digits) or Not a number.

# Constraints
* 0 < length of number <= 10000 hex digits (up to 16^10000 😲 in base 10!)
