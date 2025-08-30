# Puzzle
**TXT2HTML** https://www.codingame.com/training/hard/txt2html

# Goal
Transform a given array to text form in html code.

Corners of each cell of the array are represented by the character +.  
Horizontal lines between two corners of a cell are represented by the character -.  
Verticals lines between two corners of a cell are represented by the character |.  

Cells can be empty or contain (anywhere between the four corners) one or more lines of data. In the case of more than one line of data, carriage returns between lines are replaced by spaces in the html code. Spaces before and after data of each line are ignored.

# Input
* Line 1 : An integer N for the number of lines.
* N next lines : A String s representing a part of the array to be transform in HTML.

# Output
* Line 1 : the tag <table>
* Next lines: The representation HTML of each line of the array in the form : ```<tr><td>Content of cell 1</td><td>Content of cell 2</td></tr>```
* Last line : the tag </table>

# Constraints
* 3 ≤ N ≤ 20
* Length of s ≤ 50
