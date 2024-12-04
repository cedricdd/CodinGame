# Puzzle
**BitBurner Decoder** https://www.codingame.com/contribute/view/113403c7f0836b7499133a0a292d47c2ed125b

# Goal
You've been playing BitBurner (https://bitburner-official.github.io/) and notice some of the text is obfuscated. It has some errors in it making it impossible to read but the errors keep changing. You have an idea to keep track of the changes long enough to guess with high certainty what the hidden word is.

One of the first clues you get is the name of one of the obfuscated gangs "Slum Snakes". Before finding out the name you saw that it was sometimes displayed as "Plum_SnikYs" or "SWum MnakiL" or one of many other variants with errors. On the next restart you keep track of a bunch of variations and notice that the errors are random character substitutions and the number of characters remains constant.

You've written a script and extracted many variations of obfuscated phrases (the test cases). You now need to write the code to extract the most likely phrase given your insight that the errors are character level random substitutions.

# Input
* Line 1: n An integer for the number of samples
* Next n Lines : text Sample text

# Output
* A single line containing the decoded text

# Constraints
* 2 < n < 250
* 2 < length of text < 50
