# Puzzle
**Tetrasticks** https://www.codingame.com/training/medium/tetrasticks

# Goal
After months of struggling, little Jimmy finally solved the Tetrasticks puzzle. Frustrated with how tricky it was, he started gluing the pieces to the game board. But just as he was in the middle of it, he opened a window and went to the bathroom. Suddenly, a gust of wind blew in, knocking the board to the floor! Now, only the glued pieces remain in place, while the rest are scattered.

You must quickly restore the puzzle before Jimmy notices, or he'll throw a fit again! Carefully place the missing pieces to fill the board, making sure everything fits perfectly.

# Rules
You will be given a board description, that has to be entirely covered using the available tetrasticks.  

* Each tetrastick is composed of 4 line segments.
* Retrasticks can share the same intersection but can't cross each other.
* Tetrasticks can be flipped horizontally and/or rotated by 0°, 90°, 180°, or 270°
* Below is an overview of all 16 tetrasticks used in the puzzle with their respective IDs, partially resembling their shapes.
* 
![22dd689fc400f7839563dfe02f84d576319ecdaea4969f8650c4d35e874f10f1](https://github.com/user-attachments/assets/f06dd79d-66aa-434b-ae4e-ec726ad3f076)

Your task is to fill a 5×5 board of squares or, more precisely, a 6×6 grid of edges using the provided tetrasticks. Some tetrasticks may already be glued to the board, so pay close attention to the input.

Each turn, you must place one tetrastick on the board. To do so, you need to specify:  
* The ID of the tetrastick you want to place.
* Whether you want to flip it horizontally.
* The number of times you want to rotate it clockwise.
* The row and column where you want to place it.

Make sure all pieces fit correctly within the grid! 

![451a17bc3e846b7130ebca9336906b1121b27c3392508ae213008f436c7bf630](https://github.com/user-attachments/assets/09d58d91-2ed7-4e61-8a83-6c1654ef26ba)

**Example - Tetrastick transformation and placement**
The R tetrastick as shown in Fig 1, requires you to flip it horizontally (flip = 1) and rotate it twice (rotate = 2): 
![0dfd28a026ce147ac057df8f01f1d789e75705435831124b8fdbda90375a508b](https://github.com/user-attachments/assets/48b68431-8ea1-4f09-8b22-ead737177e4a)

The bounding box of this tetrastick is 2×2. The row and column values represent the position of the top-left corner of the bounding box. In the example above, that would be row = 0 and column = 2.

A tetrastick placement is described using its id, flip, rotate, x and y separated by space. For example: R 1 2 0 2

At the beginning of each turn, you will receive a complete description of the board, which consists of the placement descriptions of all already placed tetrasticks. At the end of your turn, you must output the placement description of a single tetrastick. 

# Input
Every turn you will receive current configuration in following format:  
* Line 1: number m representing amount of remaining tetrasticks to place
* Line 2: m space separated IDs of remaining tetrasticks
* Line 3: number n representing amount of tetrasticks already placed on board
* Following n lines: placed tetrasticks as described in example, for example: R 1 2 0 2 (id, flip, rotate, x, y)
  
# Output
* 1 Line: 5 Space separated values id, flip, rotations, row, column
    * id of tetrastick
    * flip 1 if tetrastick should be flipped horizontally, 0 otherwise
    * rotations from interval <0 ; 3> - count of clockwise rotations
    * row from interval <0 ; 5> - vertical placement
    * column from interval <0 ; 5> - horizontal placement

For example H 1 2 0 3 will flip (1) horizontally h-shaped tetrastick (H ) and rotate it 2 times clockwise. After that the tetrastick will be placed on first row and fourth column.

# Constraints
* Allotted response time to output is ≤ 2s in first turn and 50ms in remaining turns
