# Puzzle
**Elementary cellular automaton** https://www.codingame.com/training/medium/elementary-cellular-automaton

# Goal
Your goal is to write a program that can show the evolution of an Elementary Cellular Automaton!  
This is a one-dimensional binary system in which each cell (0 or 1) evolves to the next stage based on its own value and the values of its immediately adjacent neighbors.  

For example, consider the pattern:
```
0010110
```

In order to determine the next value for the 4th cell, we look at the neighborhood: 101, composed of the 3rd cell, 1, 4th cell 0, and 5th cell, 1.

Since neighborhoods can have any one of 8 different values (000 - 111) there are 256 possible rules for determining how the automaton should evolve any given neighborhood into either a 0 or a 1.

For example, a rule could state that neighborhoods that resemble 001 will evolve into 1, and all other neighborhoods will evolve into 0.   
In this case, the pattern 000100 would evolve as shown:
```
000100
001000
010000
```

In this puzzle, the rule will be provided in the Input in the form of a Wolfram code (a single 8-bit number)  
where each digit in the binary representation of the code represents the evolution for the corresponding neighborhood.

For example, if the provided rule is the code 53, or 00110101 in binary, then this would be interpreted as follows:
```
Neighborhood:	111   110   101   100   011   010   001   000
Next value:	  0     0     1     1     0     1     0     1
```

And so a neighborhood resembling 010 would evolve into a 1, while a neighborhood resembling 110 would evolve into a 0.

For further explanation, see: wikipedia.org/wiki/Elementary_cellular_automaton#The_numbering_system

Note: The system is periodic, or wrapped around, meaning that for the pattern [ . . @ . @ ], the neighborhood for the 1st cell is [ @ . . ],  
the 2nd is [ . . @ ], the 3rd is [ . @ . ], the 4th is [ @ . @ ], and the neighborhood for the last cell is [ . @ . ].

# Input
* Line 1: A rule R provided as a Wolfram code.
* Line 2: The number N of lines to output.
* Line 3: The starting pattern to evolve. @ and . represent 1 and 0.

# Output
* N lines: The evolution of the starting pattern. The first line must be the starting pattern, itself, and the next N-1 lines represent the subsequent evolutions from the starting pattern.

# Constraints
* 0 ≤ R ≤ 255
* 10 ≤ pattern.length ≤ 50
