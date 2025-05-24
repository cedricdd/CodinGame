## Puzzle
**Who is leading ?** https://www.codingame.com/training/easy/who-is-leading

# Goal
In rugby, you can score in 4 ways: 
* a try is worth 5 points
* a conversion is worth 2 points
* a penalty is worth 3 points
* a dropped goal is worth 3 points

Given the timestamps and the number of points scored for each team at each score, calculate the total advantage time for each team during the match. A team has the advantage when its total score is greater than the other team's.  
Consider that the points are scored at the beginning of a minute.

A match is 80 minutes long.  

# Input
* Line 1: a string teams, the name of each team, separated by a comma
* Line 2: a string scores1, 4 sorted lists of space-separated integers, representing timestamps for when the first team scored: a try, a conversion, a penalty, and a dropped goal. The four lists are comma-separated and any of them may be empty.
* Line 3: a string scores2, representing timestamps for the second team, in the same format as that for the first team.

# Output
* Line 1: data for the first team
* Line 2: data for the second team
    * data is in the format of name: score time where:
    * name is the team's name
    * score is the team's final score
    * time is the time in minutes during which the team has an advantage

# Constraints
* 1 ≤ Timestamps (in minutes) ≤ 80
* Timestamps are integers.
