# Puzzle
**EUROPEAN RUGBY CHAMPIONS CUP RANKING** https://www.codingame.com/training/medium/european-rugby-champions-cup-ranking

# Goal
Every year the best rugby teams in Europe compete in the European Rugby Champion's Cup (ERCC). Since 2014 the tournament is organized as follows:  
- 20 teams are split into 5 pools of 4 teams. During the pool stage, each team plays the 3 other teams of the pool twice (home/away games).
- Then the 8 best teams (the 5 pool leaders and 3 best runners-up) play the quarter-finals, such as:
- The best leader (#1) receive the third best runners-up(#8)
- The second best leader (#2) receive the second best runners-up(#7)
- The third best leader (#3) receive the best runners-up(#6)
- The fourth best leader (#4) receive the worst leader (#5)
- Then it is classical semi-finals and final.

Given the 4 teams of each group and the 60 games results of the pool-stage, your goal is to display the 4 quarter-finals.

INTRA-POOL RANKING RULES:  
- Each team plays 6 games. A victory is worth 4 ranking-points, a draw 2 ranking-points, a loss 0 ranking-point. Each team can have up to 2 bonus ranking-points per game: 
1 ranking-point for each team that scored at least 4 tries, 1 ranking-point for the losing team if they lost by a maximum of 7 game-points.
- In the event of a tie between two or more teams, the best-ranked team is selected using following tie-breakers:
- The team with the greatest number of ranking-points (including bonus points) from only games involving tied teams.
- If equal, the team with the best aggregate game-points difference from those games (game-points scored minus game-points conceded) (In this puzzle, you won't need more tiebreaker criteria).

INTER-POOL RANKING RULES:  
To rank teams that are not in the same pool (in order to find who is qualified to the quarter-finals), the following criteria are used:  
- Ranking in their pool (Leader, runner-up, third place, last place)
- Highest number of ranking-points in their pool
- If equal, best aggregate game-points difference (game-points scored minus game-points conceded) (In this puzzle, you won't need more tiebreaker criteria).

# Input
* 5 lines: 4 Teams for each pool, separated by a comma. Ex: ASM Clermont Auvergne,Saracens,Munster,Sale Sharks
* 60 lines: games, format: TEAM_A,GAME_POINTS_TEAM_A,NB_TRIES_TEAM_A,TEAM_B,GAME_POINTS_TEAM_B,NB_TRIES_TEAM_BEx: Harlequins,25,1,Castres Olympique,9,0 means that Harlequins defeated Castres Olympique 25 to 9, with Harlequins scoring 1 try and Castres Olympique scoring no try.

# Output
* 4 lines: The four 1/4 finals, in order:
    * TEAM_RANKED_#1 - TEAM_RANKED_#8
    * TEAM_RANKED_#2 - TEAM_RANKED_#7
    * TEAM_RANKED_#3 - TEAM_RANKED_#6
    * TEAM_RANKED_#4 - TEAM_RANKED_#5

# Constraints
* 0 <= Game_Points <= 120
* 0 <= Nb_Tries <= 20
