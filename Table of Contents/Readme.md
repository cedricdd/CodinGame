# Puzzle
**Table of Contents** https://www.codingame.com/training/easy/table-of-contents

# Goal
You are writing a book, and the table of contents is the only thing left to do.   
Sadly, the necessary packages are not working well, so you will have to implement one yourself.  

To generate the table of contents, your program will read N entries, describing a section with its level, title and page.  
- The level is given by the number of > at the start of the entry.
- The title will not contain any space nor > characters.
- The page is an integer, separated from the title by a space.
- 
Your program will then output the table of contents with the right format, N lines containing :
- An indentation to reflect the level, 4 spaces per level.
- The number of the section
- Its title
- A variable number of dots, for each line to be lengthofline long (including the page number)
- The page number

# Input
* Line 1 Length of line: lengthofline
* Line 2 Number of entries: N
* Next N lines Entries in inappropriate format

# Output
* N lines: Entries, 1 per line, in the good format.

# Constraints
* 1 ≤ N ≤ 30
* 30 ≤ lengthofline ≤ 50
