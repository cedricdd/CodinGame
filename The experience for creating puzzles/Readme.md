# Puzzle
**The experience for creating puzzles** https://www.codingame.com/training/medium/the-experience-for-creating-puzzles

# Goal
BlitzProg adapts himself to the new experience system. To stand a chance against the top end tier Codingamers, he now needs to create puzzles.

BlitzProg solves his own puzzles once they get accepted to maximize experience gain, for a total of 300xp per puzzles.

The xp needed to reach the next level is ( CurrentLevel * Sqrt(CurrentLevel) * 10 ), rounded down.

You're given the current Level and XP needed for BlitzProg to level up. Your goal is to find out what these stats will be after N of his puzzles are approved.

# Input
* Line 1: An integer Level for the current level BlitzProg has reached.
* Line 2: An integer Xp for how much xp BlitzProg needs to level up.
* Line 3: An integer N for how many BlitzProg puzzles Codingame has accepted.

# Output
* Line 1: The level BlitzProg has reached
* Line 2: How much xp BlitzProg needs to reach the next level.

# Constraints
* 1 ≤ Level ≤ 100
* 1 ≤ Xp ≤ 10000
* 0 ≤ N ≤ 100
