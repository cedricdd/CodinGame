# Puzzle
**Pachinko Jackpot** https://www.codingame.com/training/easy/pachinko-jackpot

#Goal
In the arcade game pachinko, also called plinko, a ball or chip is dropped from the top of a triangular board and randomly bounces off pegs as it descends. In this electronic version, a sprite bounces off one peg in each row and wins a prize if it lands in a catcher at the bottom. Here is a possible trajectory on a 5-high pachinko board:
```

           ●
           ◦↘
         ◦   ◦↘
       ◦   ◦  ↙◦
     ◦   ◦   ◦↘  ◦
   ◦   ◦   ◦   ◦↘  ◦
   |   |   |   | ● |
 ᴜ │ ᴜ │ ᴜ │ ᴜ │ ᴜ │ ᴜ
```

You are given the height of a conceptual pachinko game, a list of increment values for each row of pegs, and prize amounts for the catchers. Each peg increments a counter by the corresponding value when hit. This sum along its trajectory then becomes a multiplier for any prize won by that sprite.

For example, the increment data 0, 12, 012, 0120, 12012 is mapped as follows, with prize amounts as shown at the bottom:
```
           ●
           0↘
         1   2↘
       0   1  ↙2
     0   1   2↘  0
   1   2   0   1↘  2
   |   |   |   | ● |
900│600│300│500│700│800
```

For this path, the counter totals 7, multiplied by a potential prize of 700. This is in fact the largest jackpot that can be awarded, which is your goal to determine... and win if possible!

# Input
* Line 1: An integer height
* Next height lines: A digit increment for each peg in the row, not spaced
* Next 1 + height lines: An integer prize

# Output
* Line 1: An integer jackpot for the largest possible win

# Constraints
* 0 ≤ increment ≤ 9
* height < 102
