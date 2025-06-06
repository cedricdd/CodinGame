# Puzzle
**Histogram** https://www.codingame.com/training/easy/histogram

# Goal
You have to print the horizontal histogram of occurrences of letters from the given texts. We only want the letters from A-Z and a-z. Letters of different cases are treated as the same letter when counting.  
The histogram shows the percentages.

You have to write the histogram with the letters A to Z on the Y axis and the percentages on the X axis.  
The values are rounded to 2 decimal places.  
The lengths of the histogram bars are rounded to the nearest integer. For example, a value of 4.85 would have 5 blank spaces, while a 0.4 would have 0.  
```
  +------------------------------------+
A |                                    |36.36%
  +------------------------------------+
B |0.00%
  +
C |0.00%
  +---------+
D |         |9.09%
  +---------+
E |0.00%
  +------------------+
F |                  |18.18%
  +---------+--------+
G |         |9.09%
  +---------+
H |0.00%
  +
I |0.00%
  +
J |0.00%
  +
K |0.00%
  +
L |0.00%
  +
M |0.00%
  +
N |0.00%
  +
O |0.00%
  +
P |0.00%
  +
Q |0.00%
  +
R |0.00%
  +------------------+
S |                  |18.18%
  +------------------+
T |0.00%
  +
U |0.00%
  +---------+
V |         |9.09%
  +---------+
W |0.00%
  +
X |0.00%
  +
Y |0.00%
  +
Z |0.00%
  +
```

# Input
* A string S for the text.

# Output
* A histogram of percentages of occurrences of letters in S.

# Constraints
* S contains at least one letter.
* 1 ≤ length of S ≤ 1000
