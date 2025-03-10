# Puzzle
**Ancestors & Descendants** https://www.codingame.com/training/medium/ancestors-descendants

# Goal
Print the names of a family's descendants.

An individual in the family is represented by a line of input.  
The parent/child relationship of that individual is determined by the number of dots preceding his or her name. 

Each dot represents a previously mentioned ancestor in the family tree. So if a name is preceded by two dots, then the first dot represents the most recently mentioned name with zero dots before it, and the second dot represents the most recently mentioned name with a single dot before it.

An example set of input lines to represent a family would be:  
Jade  
.Andrew  
..Rose  
.Mark  
Heidi  

The explanation for this input is:  
Jade is a grandfather.  
Andrew is Jade's son.  
Rose is Andrew's daughter.  
Mark is Jade's son.  
Heidi has no children.  

The correct output lines to represent this family's descendants would be:  
Jade > Andrew > Rose  
Jade > Mark  
Heidi  

# Input
* Line 1: An integer N for the number of family members.
* Next N lines: Each line represents one family member.

# Output
* Output the family descendants full names each on a separate line.
