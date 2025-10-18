# Puzzle
**Simple AI duels** https://www.codingame.com/training/easy/simple-ai-duels

# Goal
You have to simulate a duel where two simple AI can either cooperate or defect in each turn, and determine which AI has won a duel (earned a higher total reward).

If they both cooperate (C), they both earn a reward of c each.  
If they both defect (D), they both earn a reward of d each.  
Else, the one that defects earns a reward of t and the one that cooperates earns a reward of f.  
For the purpose of this puzzle, these four values will be fixed: c=2, d=1, t=3 and f=0.  

Each AI has its own strategy. A strategy is a set of commands, each of which is a condition followed by an action (C, D or RAND).   
In each turn, the conditions are evaluated one by one. The action associated with the first true condition is chosen. For example:  
```
OPP -1 C C
* D
```
This means if the previous action of the opponent is C, then cooperate too.  
Else, defect.

Below are the codes used to describe a strategy. They generally follow the global syntax of Who What Action.  
(Assume it is the turn for Mya now. The opponent is called Opal.)  
* \* Y: In all cases, do Y.
* OPP -1 X Y: If the previous action of Opal is X, do Y.
* ME MAX X Y: If the previous actions of Mya are dominated (>, not ⩾) by X, do Y.
* OPP LAST N X Y: If the previous N actions of Opal are dominated by X, do Y. (You may think of LAST as MAX with a short memory.)   
If less than N turns have been played, consider all the turns played (excluding the current turn).  
* START Y: At the start of a duel, do Y.
* ME WIN Y: If Mya has earned a higher total reward than Opal, do Y.

Previous action(s) refer to action(s) up to the last turn. For example, in the first turn, if Mya plays first, Opal does not treat Mya's first chosen action as a previous action.

X may be C or D but Y may be C, D or RAND.

RAND means that the AI acts pseudo randomly.   
The random choice is given by a linear congruential generator (LCG) (Knuth’s pseudo random number generator) for which a, b and the modulus m are given.  
The very first x = 12, which is not used for the first pseudo-random value.  
If the current value in the LCG is x, the next one is 137*x+187 mod 256→x.  
If the binary decomposition of the calculated x has an even number of 1, choose D. Else, choose C.  
Both AI use the same LCG throughout all the turns.  

# Input
* Line 1: The number of turns
* Line 2: The number n of commands for the first AI and its name
* Next n lines: The first AI’s strategy
* Next line: The number m of commands for the second AI and its name
* Next m lines: The second AI’s strategy

# Output
* The name of the winner AI, or DRAW in case of equality, after the specified number of turns have been played
