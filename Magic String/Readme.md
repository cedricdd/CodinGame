# Puzzle
**Magic String** https://www.codingame.com/training/easy/magic-string

# Goal
An IT company is going to hold its annual dinner and party for staff, albeit in online virtual form.  
Secretary Betty is responsible for organizing speeches, announcements, awards, food and drinks and games to entertain the participants.   
(Food and drinks are offered in the office. Work-from-home and remote staff have to buy their own pizzas to eat at home. 😒)  

To prepare for games, Betty has to divide the participants into two teams.   
Originally, she has the participant list in Excel with a column labeling a person as Team A or Team B.   
But looking up a person's name in a long list to find his team is inconvenient. A clever guy (you?) proposed a solution.  

He gave a magic string of characters, S, to Betty. By alphabetically comparing every participant's name to S, those names that are smaller than or equal to S belong to Team A; otherwise they are in Team B.

Using this method, Betty finds that all participants are evenly divided into two teams, assume the participants are in even number and their names are all unique.   
Betty is happy. She simply needs to know a person's name then immediately she knows what team that person belongs to, without looking up a list.  

To make the magic string more efficient than ever, there are extra requirements:  
* The string has to be as short as possible.
* In case there are multiple magic strings having the same shortest length and have the same team-classifying effect, the tie-breaker is to choose the alphabetically smallest one.

Betty is preparing some new lists again. Could you give her the magic string?

# Input
* Line 1: N, the number of participants, which is guaranteed to be an even number.
* N lines: Each line is a participant name. The names are written in capital letters [A-Z], have all spaces and punctuation removed. All names are unique.

# Output
* Write a line, the magic string good for evenly dividing all participants into two teams according to the above said rules.

# Constraints
* 2 ≤ N ≤ 100
* 1 ≤ Length of each name ≤ 30
