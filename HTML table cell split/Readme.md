# Puzzle
**HTML table cell split** www.codingame.com/training/medium/tired-pac-man

# Goal
You need to split a cell of an HTML table.

An HTML table is made of a list of rows, each composed of a list of cells. But beware! A cell does not necessarily occupy one column and one row! Every cell can have a "colspan" and a "rowspan", that are respectively, the number of columns and rows that the cell occupy (if either is missing it is intended to be 1).  
So you are requested to split a certain cell in either direction (horizontal or vertical), and return the new colspan and rowspan sequence of all the table's cells (that will count one more cell that the input, since the "split" have the meaning of drawing a line in the middle of the given cell, with the result of replacing one cell with two cells, preserving the relative layout with respect of the other cells).

Example, the table:
```
┌─┬─────┐
│ │  B  │
│ ├─┬─┬─┤
│A│ │D│E│
│ │C├─┼─┤
│ │ │F│G│
└─┴─┴─┴─┘
```

Is rendered by an HTML as:
```
<TR><TD rowspan=3>A</TD><TD colspan=3>B</TD></TR>
<TR><TD rowspan=2>C</TD><TD>D</TD><TD>E</TD></TR>
<TR><TD>F</TD><TD>G</TD></TR>
```

So, in this puzzle, for simplify the parsing, the input will be given just with the colspan and rowspan values of each TD, as:
```
1,3 3,1
1,2 1,1 1,1
1,1 1,1
```

So, if you are requested to split in two columns the 5th cell (the "F"), you will have:
```
┌─┬───────┐
│ │   B   │
│ ├─┬───┬─┤
│A│ │ D │E│
│ │C├─┬─┼─┤
│ │ │F│F│G│
└─┴─┴─┴─┴─┘
```

So the output would be:
```
1,3 4,1
1,2 2,1 1,1
1,1 1,1 1,1
```

Brief recap for who is not familiar with HTML table syntax:
- the table is given as a list of rows, each as a list of cells
- for each row, there are specified only the cells that have top-left corner on that row, in the order as they appears left-to-right
- each cell can possibly extend on many columns and many rows, it is always rectangular, it is never overlapped on other cells
- in each row that “receives” columns occupied from cells starting in upper rows, there are only specified the “new” cells, ordered left-to-right filling empty columns

# Input
* Line 1: An integer NR for the number of rows info that will follow
* Next NR lines: Row info, as a space separated couple of values CS,RS for the colspan and rowspan attribute of each cell in this row
* Last line: The zero based index IS of the cell to split, in the order as appeared in the input, and a character DS that indicates if the cell's split is requested in two columns ("C") or in two rows ("R")

# Output
* NR or NR+1 lines: Row info, as a space separated couple of values CS,RS for the colspan and rowspan of each cell in this row (hint: if DS is "R" then it will be one more row in the output with respect to the input)

# Constraints
* 1≤ NR ≤ 100
* The cell to be split has a span value of 1 in the direction asked (but can have any span value in the other direction).
