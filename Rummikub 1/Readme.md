# Puzzle
**Rummikub 1** https://www.codingame.com/training/medium/rummikub-1

# Goal
This is part 1 of the two-part Rummikub puzzle. In this part, the basic dynamics are introduced.

Rummikub is a game played with tiles numbered 1-13 in four colors: Blue, Green, Red and Yellow. There are two tiles of each number-color combination. Players play their tiles to form runs (same-colored uninterrupted range of numbers) or sets (same-numbered tiles all of a unique color). A valid run or set consists of at least three tiles, and a maximum of four (set) or thirteen (run). Example of a run: 3G 4G 5G 6G. Example of a set: 4B 4G 4R.

You will get a table with valid runs and sets (rows), and one tile (goalTile) to put on the table in as few actions as possible. You must output all actions needed to put the tile on the table (becoming part of a valid run or set), and the new rows of the table after those actions.

*Actions*  
One action can be one of:
* TAKE tile rowid: take a tile from a row, or
* PUT tile rowid: put a tile in a row, or
* COMBINE rowid_1 rowid_2: combine two rows.

Apply the actions according to the following rules:
* Each TAKE action must always immediately be followed by a PUT action of the same tile. (While possible in the real game, in this puzzle you are not allowed to take another tile before putting away the already taken tile)
* After each PUT action, the table should only contain valid runs and/or sets.
* Your final action is always to PUT goalTile.
* A COMBINE action can be used to merge two runs into one longer valid run. Order the rowids from the two rows numerically. The new run gets the lowest rowid (rowid1), the other rowid (rowid2) becomes unused.

You are allowed to split one valid run into two valid runs by a PUT or TAKE action. For example: TAKE the middle tile of a run of seven tiles, or PUT a tile in the middle of a run of five tiles. In case of a split, the new run with the highest numerical tile values gets a new rowid (highest rowid that existed + 1), and the other run keeps the original rowid.

Some examples of valid actions and their result on table rows:  
Starting table  
```
1 1G 2G 3G 4G
2 5G 6G 7G
3 4B 4R 4Y
```
ACTION 1: COMBINE 1 2 (This action creates a long run with lowest rowid1, higher rowid2 row is deleted)  
Table after action 1:  
```
1 1G 2G 3G 4G 5G 6G 7G
3 4B 4R 4Y
```
ACTION 2: TAKE 4G 1 (This action splits row 1; the run with highest numeric values gets a new rowid)  
ACTION 3: PUT 4G 3 (A TAKE should directly be followed by a PUT)  
Table after actions 2 and 3:  
```
1 1G 2G 3G
3 4B 4G 4R 4Y
4 5G 6G 7G
```

Runs are always displayed from low to high value. Sets are always displayed in the order B G R Y.

Action selection and order  
When different series of actions would lead to the same output, follow the rules below:  
- Always select the least number of actions;
- COMBINE always as early as possible;
- COMBINE lower-numbered rowids before higher-numbered rowids (e.g. COMBINE 1 2 before COMBINE 1 3, COMBINE 2 6 before COMBINE 3 4).

Note  
The real Rummikub allows for more complex actions (multiple TAKE after each other, after a single PUT the runs or sets do not need to be valid yet, as long as more PUTs are coming). To reduce difficulty of this puzzle, this is left out (the creator of the puzzle was not able to solve this).  
Two important consequences of these rules (hint): 1) It is never possible to create a new set. It is only possible to make a set longer or shorter. 2) It is never possible to create a new run, except if it is created by splitting one run into multiple smaller valid runs.

# Input
* Line 1: string goalTile: tile to put on the table. A tile is a combination of a numeric value (1-13) and a single letter indicating the color (one of R, G, B or Y) .
* Line 2: integer nrow: number of rows (sets or runs) on the table.
* Next nrow lines: row: the rowid (1-nrow), followed by space separated strings representing tiles, that form a valid run or set.

# Output
* naction lines: the actions needed to put goalTile on the table (one action per line), in the format: PUT tile rowid, TAKE tile rowid or COMBINE rowid1 rowid2.
* nrow_new lines: the new rows that are formed after putting goalTile on the table (one row per line). The new rows have either their original rowid, or a new rowid (if it was a new row as a result from splitting an original row). Rows that became unused due to a COMBINE action should be skipped.

# Constraints
* Cases have been constructed such that there is always only one solution after following the action selection and order rules.
* naction <= 7.
