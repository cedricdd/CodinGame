# Puzzle
**Bo's Hay-Bale Messages** https://www.codingame.com/contribute/view/409059896b36f01d566b3d842bfb2cf86a625

# Goal
Origin story of business:  
Bo moved to the countryside and needed a side gig.  
He'd seen lots of signs on the roadside like "EGGS FOR SALE" and "CORN MAZE AHEAD" and "REPENT NOW"; and thought maybe he could make some money by writing out messages for people, in a unique way.

He’d noticed that the letters in "Make an Atari Font" puzzle (at https://www.codingame.com/training/easy/make-an-atari-font) resembled rectangular hay-bales stacked on top of each other, and he had lots of hay-bales.

So a business idea was born:

Bo's Hay-Bale Messages  
Bo builds each letter of the customer's message, using hay-bales, in the font from the above mentioned puzzle.
(See mock-up example in Banner image)

*Your task:*  
He has asked you to write a program to automatically generate price quotes for potential customers.  
Given the input of the message, the chosen letterColor and the chosen backgroundColor, calculate the price.

*Details and pricing:*  
Most letters will require hay-bales of two different colors:  
* the actual letterColor
* the backgroundColor because gravity exists and hay-bales can't just hover in space. 

For example: most hay-bales creating the top of a T will have to be stacked on top of "supporting" hay-bales (that are the backgroundColor)

*The price for each hay-bale:*  
* plain (i.e., not-painted): $3
* painted black or white or a primary color (red, blue, or yellow): $1 more
* painted a secondary color (violet, orange, or green): $2 more
* painted a custom color: $3 more

Suggestion: First complete the above referenced puzzle, since that font is used in this puzzle.

*NOTES:*  
Only use minimum hay-bales needed.  
Letters in the Atari font don't use all 8 available lines/levels; some are blank.  
You don't need any hay-bales for any totally blank level on the bottom.  
In other words, place letters directly on the ground.  

*“blue” means basic blue:*  
The reason for Bo’s different up-charges for the paints is that his brother Darryl gave him huge tanks of the 5 colors that are only $1 more, and his other brother Darryl gives him some barrels of the secondary colors. Anything else he’d have to buy, borrow, or figure out how to mix and make.  
The “red” (for example) is exactly the basic red shown on the color wheel. It is NOT reddish orange or rust red; those are custom colors.

# Input
* Line 1: A string message
* Line 2: A string letterColor
* Line 3: A string backgroundColor

# Output
* Line 1: An integer, the price

# Constraints
* message is upper-case letters (and spaces) only.
* letterColor and backgroundColor are all lower case.
