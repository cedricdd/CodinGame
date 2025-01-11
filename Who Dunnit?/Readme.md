# Puzzle
**Who Dunnit?** https://www.codingame.com/training/hard/who-dunnit

# Goal
Roll up your sleeves, it's time for a murder mystery! As head detective, you will find a series of clues leading to exactly one culprit. An elementary clue is a string like Madame Turquoise, the candlestick, or the reading room. These are grouped together as evidence, for instance in the following three sets:  
1. Madame Turquoise, Reverend Crimson  
2. candlestick, noose, sword  
3. reading room, bedchamber  

Within each line, one and only one of the identified individuals or items was involved in the criminal act. The first set of evidence thus indicates that either Madame Turquoise or Reverend Crimson is guilty. Set 2 in this illustration states the possibility for weapons, exactly one of which was used. Set 3 serves to identify one of two locations.

Your task is to determine which of the names within the first set is the culpable party.

Example

Suppose that there are six lines of evidence, including the three above. This means that either Madame Turquoise or Reverend Crimson is the murderer. We also know the crime involved one of three weapons and took place in either the reading room or bedchamber. A further piece of evidence is:

4. Reverend Crimson, candlestick, reading room

In each set, one of the clues is correct, and the others are not. For instance, if Reverend Crimson is the correct person, then he did not use the candlestick, nor did he kill the victim in the reading room. On the other hand, if the candlestick is the correct weapon, then it was not Reverend Crimson who vilely swung it.

5. Madame Turquoise, noose, reading room

Now we put on our deductive hats. If the homicide happened in the reading room, then neither Reverend Crimson nor Madame Turquoise could have been involved, according to the evidence in sets 4 and 5. But this is contradictory, since we already know one of them to be culpable from set 1. Hence, the reading room cannot be the correct place.

6. Reverend Crimson, sword, bedchamber

We can already deduce from set 3 that the crime occurred in the bedchamber. Finally, this last line of evidence marks Reverend Crimson as innocent, since only one of the three clues in set 6 can be correct. Therefore, the murder must have been committed by Madame Turquoise with the candlestick in the bedchamber. Another mystery splendidly solved!

# Input
* Line 1: Two space-separated integers L for lines of evidence and N for number of suspects
* Next L lines: A string evidence in the form of a set of elementary clues, comma-space separated
* The first line of evidence consists of N clues listing every suspect.

# Output
* Line 1: The identified culprit from the first line of evidence

# Constraints
* 1 ≤ L ≤ 250
* N < 12
* The problem constraints are satisfied by exactly one culprit.
