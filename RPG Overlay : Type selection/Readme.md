# Puzzle
**RPG Overlay : Type selection** https://www.codingame.com/contribute/view/104295178071842f2b3507f4343bc358c44f37

# Goal
You are creating an overlay that can give you which attack types will have the best multiplier against an enemy, usable for many games. The program already recognises the N types for each game, their efficiencies, and the types of enemies you might encounter.

An effective attack has its damage multiplied by 2, an ineffective one is divided by 2. If a type has no type against which it's effective (or none that resist), it will be stated as "None"

# Input
* 1st line: An integer N for the number of different elements
* 2nd line: An integer E for the number of opponents you'll encounter
* Next N lines: A string containing three informations separated by a comma: the first is a type, the second those it's effective against (separated by spaces), and the third those that resist it (separated by a spaces)
* Next E lines: A string with the types of the enemy

# Output
* A line giving all effective types against the opponent, in the same order as entered
