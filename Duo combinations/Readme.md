# Puzzle
**Duo combinations** https://www.codingame.com/training/medium/duo-combinations

# Goal
We as programmers know about the binary, which machine understands. A Binary combination of 0 and 1 for n bits holds 1 < < n or 2 raised to the power of n combinations.   
For example, 3-bit combinations will be: 000, 001, 010, 011, 100, 101, 110, 111  

Now, what if the bits change? It would still be a binary or a duo combination of the symbols used.   
To get over the usual 0-1 as digits or symbols, let's attempt using several distinct special character symbols for the sake of modification.   
With various symbols provided, use every character in place of 0 bit with its following character as bit 1.   
As last character would not have any character following it, do not try to have its circular pairing with first one.  

As a quick clarification, refer the following samples:  
* if characters are \@, \$ , pair up \@ with \$
* if characters are \@, \$, \\# , pair up \@ with \$, followed by \$ with \#
* if characters are \@, \$, \#, \% , pair up \@ as 0 with $ for 1, followed by \$ as 0 with \# for 1 and then \# as 0 with \% as 1.
* and so on ...

Note: In case you just receive a single character, just use the same character instead of empty output.

Given some distinct symbols as input, try to output all the unique combinations of all the two adjacent symbols as bits.   
Feel free to make use of any binary sequences generation techniques or come up with your own edition to match the order of desired output.

# Input
* 1st line contains an integer total
* Next total lines contain one character symbol to be used as a bit with its adjacent symbols.

# Output
* Various possible combinations with each combination in a separate line, having same length as the total number of given symbols, and formed with characters in adjacent rows of a given symbol.

# Constraints
* character symbols belong to { !, @, #, $, %, ^, &, *, (), [], :, ., \, / }
* 1 < total count of symbols (per testcase) < 10
