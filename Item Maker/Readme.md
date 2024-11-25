# Puzzle
**Item Maker** https://www.codingame.com/training/easy/item-maker

# Goal
You are programming a new game, but you have to create an interface for your items. Unfortunately, the amount of data is high, and you have to write a program to automate it.

Create an ASCII art of the data to add it to the game later. The frame to output depends on itemRarity.

The patterns are the followings:
```
##############
# -ItemName- #
#   Common   #
##############
```
```
/############\
# -ItemName- #
#    Rare    #
\############/
```
```
/------------\
| -ItemName- |
|    Epic    |
\____________/
```
```
X----\__/----X
[ -ItemName- ]
| Legendary  |
X____________X
```

Notes:  
- ItemName and ItemRarity have to be centered on the item
- To center a text, the extra space goes to the left: "  CenteredText "
- ItemName specific line only goes for the Legendary ItemRarity items.
- Legendary items first line depends on the length of the box:
    * odd: X---\_/---X (1 _ in the middle)
    * even: X---\__/---X (2 _ in the middle)

# Input
* Line 1: A string data the data to convert into an item in the format of itemName,itemRarity,attribute1:value1,attribute2:value2…

# Output
* The ASCII art of the item ready to be added to the game.
* Attribute order must follow input sequence

# Constraints
* 5 ≤ length of itemName or attribute or value ≤ 100
* itemRarity is always Common, Rare, Epic, or Legendary
  
