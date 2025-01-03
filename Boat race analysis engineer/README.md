# Puzzle
**Boat race analysis engineer** https://www.codingame.com/contribute/view/41431a9f0de85ab776453d1816597a08bec1d

# Goal
Hello engineer,

Congratulations you have been commissioned to finalize the latest technology in boat racing analysis. Your team has already made good progress on this itech camera embedded in a helicopter. Your teammate is already able to take out these first analysis on her own.

Your objective will be to process this information to make it visual to the spectators who follow the race live.

Your helicopter flies over the race area but it has no idea how many boats are already in the race. Your team has already succeeded in extracting two types of analysis from images:

*Possible analysis:*  
* Boat_a is in front of Boat_b
* Boat_a is not ahead of Boat_b

To make this information visual you will have to determine the position of the boats, then display in alphabetical order (case-insensitive) the position of the boats in the form "_ Boat_name" where each "_ " at the beginning of the line represents a head start.

Please note that your team has not yet managed to fix this bug:  
* The camera poorly recognizes the name of a boat so it produces erroneous information leading to a circular reference in these analysis.

When you detect a circular reference error due to a bad reading of the name of the boat   
* no boat positions have to be output
* you will have to display all the analysis subject to this circular reference in the order of appearance.

If after analysis a boat can have several possible positions, we will retain the smallest. The smallest position is the one that will show the fewest "_ " markers before the boat name.

# Input
* Line 1: The number n of analysis extracted by your team from the camera images.
* next n lines: an analysis in the form : "a is in front of b" or "a is not ahead of b"

# Output
* Display the position of boat (one line by boat) in alphabetical order (case-insensitive):

The position of the boats in the form "_ Boat_name" where each markers "_ " at the beginning of the line represents a head start.

When you detect a circular reference error due to a bad reading of the name of the boat:  
* No boat positions have to be output.
* You will have to display all the analysis subject to this circular reference in the order of appearance (one line per analysis).

# Constraints
* length of Boat_name ≥ 1
* Boat_name always starts with a letter.
* Boat_name may contain alphanumeric and special characters as well as space characters.
