# Puzzle
**The Siege Perilous** https://www.codingame.com/contribute/view/808555cf654a10d53b4cde43dab74728d023

# Goal
It gets boring in Camelot these days, and on the dullest days the Knights of the Round Table sometimes play their own version of musical chairs.

The round table is, well round, and has one more seat than the number of knights k. Seat numbers increase clockwise.  
One seat sp, is called the 'Siege Perilous' and can only be occupied safely by the Grail Knight gk. Any other knight sitting in it will instantly die.

The game goes like this:  
1. The k knights enter and, in order and occupy a seat (starting from the first seat) at the round table - but leaving the Siege Perilous sp empty.
2. Merlin decides a 'shift' number shift.
3. All the knights stand up, move around the round table clockwise that many seats, and sit down.
4. If a knight who is not the Grail Knight gk is seated in the Siege Perilous they are instantly (and magically) incinerated.
5. If the Grail Knight sits in the Siege Perilous the game is over.
6. The game has as many turns as there are seats at the table, when those turns are up the game is over.
7. If the game isn't over, the knights again stand, move the prescribed places and sit down.
8. When the game is over the (remaining) knights leave, in order, starting with the knight in the lowest numbered seat.

For example if the following knights entered in order:
```
Sir Gareth
Sir Mordred
Sir Lucan
```

and if Sir Mordred were the Grail Knight,
and the Siege Perilous were Seat 1 (of course medieval knights hadn't invented 0-indexing!)

They would sit like this
```
(SP) -> Empty
2 -> Sir Gareth
3 -> Sir Mordred
4 -> Sir Lucan
```

If the shift were '1' then on the first shift Sir Lucan would cycle to the Siege Perilous (and die), and on the second turn Sir Mordred would move to the Siege Perilous and (as he is the Grail Knight) the game would be over

The (remaining) knights would leave the room in order starting with the lowest numbered seat:
```
Sir Mordred
Sir Gareth
```

For each set of input data, print the names of the knights leaving in order - one per line.

# Input
* Line 1: an integer k - the number of knights
* Next k lines: (in order) a string n - the name of a knight
* Next Line: a string gk - the name of the Grail Knight
* Next Line: an integer sp - the number (1-indexed) of the Siege Perilous
* Next Line: an integer shift - the number of seats the knights move in the game

# Output
* A number of lines each containing the name n of a surviving knight (in order), or None if there are no knights left alive

# Constraints
* 0 < k < 20
* 0 < length < 100
* 0 < shift < 500
