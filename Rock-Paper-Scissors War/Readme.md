# Puzzle
**Rock-Paper-Scissors War** https://www.codingame.com/training/medium/rock-paper-scissors-war

# Goal
On a two-dimensional rectangular grid, a new civilization emerged.

Within the grid terrain, each location is occupied by one of the five life forms: Rocks, Papers, Scissors, Lizards or Spocks.

The life forms have these code names:
* Rock (R)
* Paper (P)
* sCissors (C)
* Lizard (L)
* Spock (S)

They defeat each others in a fixed pattern:
* Scissors cuts Paper
* Paper covers Rock
* Rock crushes Lizard
* Lizard poisons Spock
* Spock smashes Scissors
* Scissors decapitates Lizard
* Lizard eats Paper
* Paper disproves Spock
* Spock vaporizes Rock
* Rock crushes Scissors

Each day, different life forms occupying horizontally or vertically adjacent grid locations wage war.

At the end of the day, the victor life form will occupy the adjacent location originally owned by the loser.
```
Day 0          Day 1
+---+---+---+  +---+---+---+
| P | S | C |  | P | P | S |
+---+---+---+  +---+---+---+
```

A two-front war - Spock wins the war on the right but loses the war on the left.

A life form on a location can have at most four fronts of war on the same day. If it wins at any frontier, it expands to the adjacent location of that front. At the same time if It is defeated by other life forms, it retreats from the original location, or just dies out.

When two different life forms are defeating the life form on the same location at the same time, the two winners will fight each other again to decide who is the final winner to occupy the location at the end of the day.
```
Day 0          Day 1
+---+---+---+  +---+---+---+
| P | S | L |  | P | L | L |
+---+---+---+  +---+---+---+
```
Another two-front war - Spock loses both wars at two frontiers. The winners fight again and Lizard wins.

Your task is to determine the territory occupied by each life form after n days.

👉 Life form design is borrowed from another puzzle https://www.codingame.com/training/easy/rock-paper-scissors-lizard-spock. Code reuse is possible.

# Input
* Line 1: Integers w h n, separated by a space.
  * w is the width of the terrain
  * h is the height of the terrain
  * n is the number of days to pass

The following h lines: Showing what life forms are initially occupying the grid.

# Output
* Write out what life forms are occupying the grid after battling for n days. The output should have h lines of width w

# Constraints
* 1 ≤ n ≤ 50
* 1 ≤ w, h ≤ 100
