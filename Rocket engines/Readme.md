# Puzzle
**Rocket engines** https://www.codingame.com/training/medium/rocket-engines/discuss

# Goal
It is a public secret that you need a rocket to go to Mars, but only a few know that your rocket engines must be balanced.  
Because Mars is fourth planet from the Sun, your rocket has four engines positioned in matrix 2×2. Before launch, each engine has it own default power, but you as engineer and captain of rocket can change power of engines. In one turn, you can increase by 1 every engine in arbitrary row or column, and you can perform multiple actions (there is no limit).

Imbalance of rocket is defined as difference between maximal engine power and minimal engine power.  
Your goal is to find what is the minimal possible imbalance of rocket you can obtain using described action.

*Example:*  
Given default power of each engine:
```
1 1
0 3
```

Next actions are performed: 1 × first row, 2 × first column:
```
1 1 -> 2 2 -> 3 2 -> 4 2
0 3    0 3    1 3    2 3
```

So minimal imbalance of rocket is 4 - 2 = 2.

# Input
* Two lines: Matrix 2×2 which represents the default power of each rocket engine.

# Output
* A single line: Number which represents the minimal imbalance of rocket.

# Constraints
* a[i][j] - Element of matrix
* 0 ≤ a[i][j] ≤ 10⁹
