# Puzzle
**Cards castle** https://www.codingame.com/training/medium/cards-castle

# Goal
Your goal is to determine if a card castle structure is stable or not.  
You're given a 2D map composed of "." (dots), "/" and "\", representing a card castle of height H and width H * 2.

A card castle is unstable if :  
- a "/" card is missing before a "\" card (".\" is UNSTABLE)
- a "\" card is missing after a "/" card ("/." is UNSTABLE)
- two cards side by side have the same orientation ("//\" or "/\\" is UNSTABLE)
- neither another card nor the ground are below (aka. a "flying card")
- the card below has the same orientation

The structure is STABLE if and only if all cards are STABLE.

# Input
* Line 1: An integer H, the number of lines in the map
* H next lines: Each line of the map as a string

# Output
* Line 1: STABLE if the structure is stable, UNSTABLE otherwise

# Constraints
* 0 < H <= 30
