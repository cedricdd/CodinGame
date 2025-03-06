# Puzzle 
**Completed Mahjong Hands** https://www.codingame.com/ide/puzzle/completed-mahjong-hands

# Goal
Mahjong is a tabletop game played using tiles. It features three "number" suits (pins, sous, mans, represented as p, s and m) from 1 to 9, and one "honor" suit z of seven distinct tiles. Note that contrary to western card games, tiles are not unique.

![33491135-4ac4b4e6-d6f4-11e7-8df6-038f113fcef9](https://github.com/user-attachments/assets/ee59fae6-362f-4396-a49a-d13fe4e3950e)

To complete a hand and win, the 13 tiles in your hand are combined with 1 newly drawn tile and must result in one of the following winning configurations:  
* 4 sets and 1 pair, self-explanatory
* seven pairs, where all pairs are distinct (twice the same pair wouldn't qualify)
* kokushi musou: one of each of the 1 and 9 of each number suit, one of every seven honors, the remaining tile forming a pair. (e.g. 19m19p19s11234567z)

A pair is any of the two same tiles: 11m, 33s, 44p, 55z, etc.

A set consists of 3 tiles of the same suit. It can either be a run: 3 number tiles (p, s or m) in a connected run like 123s or 234s, but not 1m 2p 3s or234z; or a triplet of any suit, not necessarily numbers, like 111z, 222m.

So honor tiles (non-numbers, represented by z) can only form pairs or triplets, but not runs. 567z is not a set, 555z is a valid set, 55z is a valid pair.

A single tile can only be counted as part of one set or pair: there is no sharing or reusing.

Given a sorted hand of 13 tiles and one tile, check whether the 14 tiles make up a completed hand.

Attribution: Cover art "The mahjong game" by Lark Ascending on flickr (https://flickr.com/photos/vwilliams/5878216928)

# Input
* Line 1: A sequence of numbers and letters, Space, a tile of a number and a letter
  
In the notation, the numeric value of every tile in a suit comes first, then the suit's letter. Tiles are grouped per suit, so each letters is written at most once. 
The three numbers suits are ordered from m to p to s and consist of ranks 1 to 9. The honor suit orders last, is represented as z and consists of seven tiles from 1 to 7.
As you may have gathered from the statement, in this puzzle the honor suit's tiles are represented as digits for ease of parsing and distinction, but they do not behave like numbers.

# Output
* Line 1: TRUE if and only if it is a match, otherwise FALSE.

# Constraints
* 14 ≤ length of sequence ≤ 17
* length of tile = 2
