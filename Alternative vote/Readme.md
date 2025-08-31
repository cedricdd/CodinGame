# Puzzle
**Alternative vote** https://www.codingame.com/training/hard/alternative-vote

# Goal
Your program implement the alternative vote electoral system.

The alternative vote works by eliminating successively a candidate at each turn until only one candidate remains. A particularity of this system is that each voter provides an order of preference of the candidates from the beginning. When a candidate is eliminated, the voters that has voted for this candidate will then vote for the next candidate in their preference list that is still in the election.

In order to select the candidate to eliminate, the votes for each candidate are counted and the one with the less votes is eliminated. In case of equality in the number of votes, we will eliminate the one that appears first in the list of candidates provided as input.

Each candidate will be identified by its place in the list of candidates, starting from 1.

# Input
* Line 1: number C of candidates
* C next lines: name of each candidate
* Next line : number V of voters
* V next lines : C space separated integers corresponding to the candidate identifiers in the preference order (from the one that the voter wants to win to the one the voter wants to lose).

# Output
* C-1 lines : the name of the candidates sorted by the elimination order.
* Last line: 'winner' followed by the name of the winner.

# Constraints
* 1 < C < 10
* 1 < V < 1000
* 1 < length of name < 50
