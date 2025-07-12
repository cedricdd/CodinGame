# Puzzle
**Wesnoth fight death probabilities** https://www.codingame.com/contribute/view/1299033bbccbe2ddfa4f972450b80547b87b6a

# Goal
Battle for Wesnoth is a turn based strategy game.

A fight happens when an unit attacks another unit. In each fight, units exchange blows according to their stats.

The stats of each unit relevant for the fight are:  
* blows Number of blows.
* damage Damage of each successful blow.
* toHit Chance to hit as percentage.
* hp Remaining hit points.

A fight proceeds as follows:  
* The attacker launches a blow first. It can hit or not depending on the chance to hit.
* Then the defender launches a blow (if the unit has at least one blow, some units have 0 blows).
* They continue exchanging blows until one of them dies or both run out of blows.
* If one of them exhausts all of its blows, the opponent continues hitting until it also runs out of blows.

Example:  
The attacker has 2 blows and the defender 4. First goes the attacker, then the defender, then again the attacker and then the defender does its other 3 blows, as the attacker is out of them. The sequence goes like this:
* Attacker tries to hit (remaining blows: 1)
* Defender tries to hit (remaining blows: 3)
* Attacker tries to hit (remaining blows: 0)
* Defender tries to hit (remaining blows: 2)
* Defender tries to hit (remaining blows: 1)
* Defender tries to hit (remaining blows: 0)


Be aware that while the defender can have no blows (e.g. they have no weapons), the attacker has at least 1 blow (if not they would not be able to attack).

In each blow, there is a toHit probability of successfully hitting the opponent. If a hit is successful, damage is subtracted from the opponent's hp. A unit dies if its hit points get reduced to 0 or less.

Your task is to determine the probability of the death of each unit.

# Input
* Line 1: Space separated for the stats of the attacker unit: name0 hp0 blows0 toHit0 damage0
* Line 2: Space separated for the stats of the defender unit: name1 hp1 blows1 toHit1 damage1

# Output
* Line 1 : Space separated probabilities, first the attacker, then the defender, in percentage rounded to the nearest integer.

# Constraints
* 1 <= hp0, hp1 <= 100
* 1 <= blows0 <= 10
* 0 <= blows1 <= 10
* 10 <= toHit0, toHit1 <= 90
* 1 <= damage0, damage1 <= 100
