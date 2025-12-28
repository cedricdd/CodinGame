# Puzzle
**Set Probabilities (Card Game)** https://www.codingame.com/contribute/view/136668d136c61132f37124a7e40173b44bf737

# Goal
You have a deck of the card game set and n current cards drawn on the table. Determine the probability that after drawing 1 more card, you can form a set from the current cards.

The deck consists of one copy of each possible combination of 4 unique features with 3 variations each (a total of 81 cards). The features and variations are as follows:
* Number: 1, 2, or 3
* Shading: OUTLINED, STRIPED, or SOLID
* Color: RED, GREEN, or PURPLE
* Shape: DIAMOND, OVAL, or SQUIGGLE

For example, a card could be 2 SOLID GREEN OVAL or 1 STRIPED PURPLE SQUIGGLE.

A set is formed with three cards which display each feature either all the same or all different. It is not a set if two cards share a feature but the other card does not. For example, these are all valid sets:
```
1 STRIPED RED OVAL
2 STRIPED PURPLE OVAL
3 STRIPED GREEN OVAL
```
```
2 SOLID PURPLE OVAL
2 SOLID PURPLE DIAMOND
2 SOLID PURPLE SQUIGGLE
```
```
1 OUTLINED PURPLE DIAMOND
2 SOLID RED OVAL
3 STRIPED GREEN SQUIGGLE
```

And these are all invalid sets:
```
1 SOLID RED OVAL
1 OUTLINED RED OVAL
1 STRIPED GREEN OVAL
```
```
3 OUTLINED PURPLE DIAMOND
2 STRIPED PURPLE SQUIGGLE
3 SOLID PURPLE SQUIGGLE
```
```
1 SOLID RED DIAMOND
2 STRIPED PURPLE OVAL
2 STRIPED GREEN OVAL
```

Note that the card you draw does not have to be used in the sets formed if there are already sets on the table.

# Input
* Line 1: An integer n for the number of cards currently on the table
* Next n lines: Four space separated features describing a card in the following order: Number, Shading, Color, Shape.

# Output
* Line 1: A probability p as a decimal from 0 to 1 rounded to 4 decimal places.

# Constraints
* 2 ≤ n ≤ 20
