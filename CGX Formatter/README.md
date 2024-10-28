# Puzzle
**CGX Formatter** https://www.codingame.com/training/hard/cgx-formatter

At CodinGame we like to reinvent things. XML, JSON etc. that’s great, but for a better web, we’ve invented our own text data format (called CGX) to represent structured information.

CGX content is composed of ELEMENTs.

*ELEMENT*  
An ELEMENT can be of any of the following types BLOCK, PRIMITIVE_TYPE or KEY_VALUE.

*BLOCK*  
A sequence of ELEMENTs separated by the character ;
A BLOCK starts with the marker ( and ends with the marker ).

*PRIMITIVE_TYPE*  
A number, a Boolean, null, or a string of characters (surrounded by the marker ')

*KEY_VALUE*  
A string of characters separated from a BLOCK or a PRIMITIVE_TYPE by the character =

Your mission: write a program that formats CGX content to make it readable!
Beyond the rules below, the displayed result should not contain any space, tab, or carriage return. No other rule should be added.​

    The content of strings of characters must not be modified.
    A BLOCK starts on its own line.
    The markers at the start and end of a BLOCK are in the same column.
    Each ELEMENT contained within a BLOCK is indented 4 spaces from the marker of that BLOCK.
    A VALUE_KEY starts on its own line.e.
    A PRIMITIVE_TYPE starts on its own line unless it is the value of a VALUE_KEY.

# Input
* Line 1: The number N of CGX lines to be formatted
* The N following lines: The CGX content. Each line contains maximum 1000 characters. All the characters are ASCII.

# Output
* The formatted CGX content

# Constraints
* The CGX content supplied will always be valid.
* The strings of characters do not include the character '
* 0 < N < 10000
