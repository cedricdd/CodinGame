# Puzzle
**ASCII Abacus** https://www.codingame.com/contribute/view/1534984cd7621db34eaa0831ee22a72188ac66

# Goal
The Japanese abacus (soroban) is a calculation tool that uses vertical columns (|) of beads to represent a floating-point number. Each column has 1 bead on the top and 4 beads at the bottom; the position of the beads denotes a corresponding place (digit) value of the resultant number.

The abacus, with all columns set to value 0, looks like this in ASCII:
```
 _________________________________________________________ 
/  _____________________________________________________  \
| | <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> | |
| |__|___|___|___|___|___|___|___|___|___|___|___|___|__| |
|  __________________________.__________________________  |
| |  |   |   |   |   |   |   |   |   |   |   |   |   |  | |
| | <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> | |
| | <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> | |
| | <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> <_> | |
| |_<_>_<_>_<_>_<_>_<_>_<_>_<_>_<_>_<_>_<_>_<_>_<_>_<_>_| |
\_________________________________________________________/
```

To read the number displayed on the abacus, follow these steps in order:

1. Find the dot (.) located on the middle row of the abacus frame. The column indicated by the dot denotes the ones digit place - all columns to the left of and including the dotted column represent the integer value of the number, while all columns to the right of (and excluding) the dotted column represent the decimal value of the number.

2. Determine each place value from the bead positions in each column. If the top bead is shifted down towards the middle row of the abacus frame, that bead adds 5 to the total place value. For each bottom bead shifted up towards the middle row of the abacus frame, that bead adds 1 to the total place value.

3. String all place values together (accounting for the decimal point) and truncate unnecessary leading and/or trailing zeroes and/or the radix character (.) to obtain the final value of the represented number.

For example, the following ASCII abacus represents the number 12345.6789:
```
 _________________________________________________________ 
/  _____________________________________________________  \
| | <_> <_> <_> <_> <_> <_>  |   |   |   |   |  <_> <_> | |
| |__|___|___|___|___|___|__<_>_<_>_<_>_<_>_<_>__|___|__| |
|  __________________________.__________________________  |
| |  |   |  <_> <_> <_> <_>  |  <_> <_> <_> <_>  |   |  | |
| | <_> <_>  |  <_> <_> <_> <_>  |  <_> <_> <_> <_> <_> | |
| | <_> <_> <_>  |  <_> <_> <_> <_>  |  <_> <_> <_> <_> | |
| | <_> <_> <_> <_>  |  <_> <_> <_> <_>  |  <_> <_> <_> | |
| |_<_>_<_>_<_>_<_>_<_>__|__<_>_<_>_<_>_<_>__|__<_>_<_>_| |
\_________________________________________________________/

```
Now you try!

Abacus (soroban): https://en.wikipedia.org/wiki/Soroban
ASCII art credit: https://ascii.co.uk/art/abacus

# Input
* 11 lines: A 59-character string, denoting a single row of the ASCII abacus.

# Output
* Line 1: The value represented by the abacus in simplified form (with unnecessary leading/trailing zeroes removed). If the decimal value of the number is zero, omit the radix character (.) from the output as well.

# Constraints
* The abacus frame will always be in the same position, as shown in the given examples.
* Each vertical column (|) will always be in the same position, as shown in the given examples.
There are only 10 bead positions (denoting 0-9), as shown in the given examples.
The middle row of the abacus frame will always have exactly one dot (.).
