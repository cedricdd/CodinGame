# Puzzle
**Universe Conquest** https://www.codingame.com/training/hard/universe-conquest

# Goal
The universe is made up of P planets numbered from 1 to P.  
There are H hyperspace roads, linking those planets.  
Two different space factions own and defend the planets : E, the empire and R the republic.  

In order to conquer this universe, you have come up with a plan : you need to destroy those hyperspace roads. The problem is that if you attack any hyperspace road, the armies from both planets will come to defend it. You realize now that if both the empire E and the republic R defend the hyperspace road, your attack will fail... miserably.

You decide that, before attacking the hyperspace roads, you will attack some planets first to destroy the armies defending it. This way, you will be able to carry on with your plan. It will be difficult. You estimate that, in order to destroy the armies protecting each planet, you will need a certain number of your best ships : S.

Your goal is to determine which planet(s) to attack, using as few ships as possible.  
You must make sure that no hyperspace road stands connecting a planet defended by the empire E and one defended by the republic R.

# Input
* Line 1 : An integer P and an integer H defining the number of planets and hyperspace roads.
* P next lines : The planets. Each line has a character A defining the faction (either 'E' or 'R') and an integer S defining the number of ships to wipe out the defending army.
* H next lines : The hyperspace roads. Each line has 2 integers P1and P2 defining the planets linked by this hyperspace road.

# Output
* Line 1 : An integer T stating the minimum total ships required to conquer the universe.

# Constraints
* 1 < P <= 30
* 0 <= H <= 200
* 1 <= S <= 100
