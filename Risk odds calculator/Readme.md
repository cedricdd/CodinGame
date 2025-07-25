# Puzzle
**Risk odds calculator** https://www.codingame.com/training/medium/risk-odds-calculator

# Goal
You've already claimed Africa, and North America is nearly yours. Only Greenland remains between you and total victory. Can you seize this final territory before your enemies retaliate and obliterate you?

In a game of Risk, battles ensue between stacks of armies for world domination.  
In your final Greenland conquest, You, the attacker, roll the following number of dice, according to the number of your attacking armies in the battleground:
```
+--------+---+---+---+---+----+
| Armies | 1 | 2 | 3 | 4 | 5+ |
+--------+---+---+---+---+----+
|  Dice  | 1 | 2 | 3 | 3 | 3  |
+--------+---+---+---+---+----+
```
The defender rolls the following number of dice, according to the number of defending armies in the battleground:
```
+--------+---+---+---+---+----+
| Armies | 1 | 2 | 3 | 4 | 5+ |
+--------+---+---+---+---+----+
|  Dice  | 1 | 2 | 2 | 2 | 2  |
+--------+---+---+---+---+----+
```
The highest value from the attacker's dice is compared with the highest value from the defender's dice. The player with the lower roll loses an army. In the event of a tie, the defender prevails, and the attacker loses an army.

If both parties have thrown at least two dice, the second-highest values are compared, following the same rules.

Each time a battle round ends, you initiate another round with the remaining armies. As the attacker, you're determined to claim Greenland this turn, vowing to fight until only one army stack remains.

For example:  
You: attack = 5 armies, defender: defense = 4 armies:  
You roll 1, 5 & 5. Defender rolls 2 & 5. 5 <= 5, 5 > 2, both players lose one army.  
You: 4 armies, defender: 3 armies:  
You roll 4, 2 & 6. Defender rolls 5 & 3. 6 > 5, 4 > 3, defender loses two armies.  
You: 4 armies, defender: 1 army:  
You roll 3, 4 & 2. Defender rolls 6. 4 <= 6, you lose one army.  
You: 3 armies, defender: 1 army:  
You roll 1, 1 & 5. Defender rolls 4. 5 > 4, defender loses last army.  
At last, you capture Greenland and emerge victorious, as Africa + North America was your secret objective!  

The aim of this exercise is to compute your probability of winning the game as the attacker at the start of the battle.

# Input
* Line 1: the attack army size.
* Line 2: the defense army size.

# Output
* The attacker victory odds in percentage, rounded to the nearest 0.01% (e.g., 73.68%).

# Constraints
* 0 < attack < 100
* 0 < defense < 100
