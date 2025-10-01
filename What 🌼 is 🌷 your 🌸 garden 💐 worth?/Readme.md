# Puzzle
**What 🌼 is 🌷 your 🌸 garden 💐 worth?** https://www.codingame.com/training/easy/what-is-your-garden-worth

# Goal
You have planted an emoji garden, but it has some empty spots and some ASCII-weeds growing in it too.

The local buying co-op has published its offeringStatement which shows the emojis it will buy this season, and how much it is offering for each (dollarAmount).
(It likely won't buy every type of emoji and of course it doesn't buy weeds or empty space.)

Calculate the worth of your garden.

NOTE: garden is not necessarily a perfect rectangle.

# Input
* Line 1: An integer numOfLinesOfOfferingStatement, which is the number of lines of offeringStatement
* Next numOfLinesOfOfferingStatement: A string consisting of $dollarAmount (an integer), followed by = (with a space on either side), followed by each emoji that is worth that dollarAmount. (There is no space between emojis.)
* Next Line: An integer, gardenHeight, representing the number of rows that are the garden
* Next gardenHeight Lines: the garden

# Output
* Line 1: An integer, the worth of your garden. Include $ and include a comma (,) as needed for "thousands separator"
