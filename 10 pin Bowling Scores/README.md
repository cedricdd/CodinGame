# Puzzle
**10 pin Bowling Scores** https://www.codingame.com/training/easy/10-pin-bowling-scores

# Goal
A game of 10 pin bowling is played over the course of 10 frames.  
At the beginning of each frame, 10 pins are arranged at the end of a bowling lane.  
Each frame, The bowler receives 2 attempts to roll a bowling ball down the lane and knock over as many pins as possible.  

**Scoring works in the following way:**

1. The bowler scores 1 point for each pin they knock down in a frame.

2. If all of the pins are knocked down on the second attempt, the bowler receives a Spare. This is worth 10 points plus 1 point for every pin knocked down by the bowler's next ball. For example:

* In the 1st frame, a bowler knocks down 8 pins with their first ball and the remaining 2 pins with their second ball and receives a Spare. In the second frame, the bowler knocks down 6 pins with their first ball and 3 pins with their second ball. The points earned in the first frame is 16 (10 + 6). 10 from the pins from the first frame and 6 from the first ball in the second frame.

3. If all of the pins are knocked down on the first attempt, the bowler receives a Strike. This is worth 10 points plus 1 point for every pin knocked down by the bowler's next two balls. For example:

* In the 1st frame, a bowler knocks down all 10 pins with their first ball and receives a Strike. In the second frame, they knock down 6 pins with their first ball and 3 pins with their second ball. The points earned from the first frame is 19 (10 + 6 + 3).

**Another example:**

* In the second frame, a bowler knocks down all 10 pins with their first ball and receives a Strike. In the third frame, they knock down all the pins with their first ball receiving a second Strike. In the fourth frame, they knock down 7 pins with their first ball and the remaining 3 pins with their second ball. The points earned from the second frame is 27 (10 + 10 + 7). The points earned from the third frame is 20 (10 + 7 + 3).

**Final Frame:**

In the 10th frame of a bowling game, there are 3 possible outcomes:

1. The bowler does not knock down all of the pins with their 2 attempts. At this point, they can earn no additional points.

2. The bowler scores a Spare with their second ball. This results in a new set of 10 pins being set and the bowler receives 1 bonus roll to add to their score.

3. The bowler scores a Strike with their first ball. This results in a new set of 10 pins being set and the bowler receives 2 bonus rolls to add to their score.

3a. If on the first bonus ball the bowler knocks down all of the pins, they receive 10 bonus points for the 10th frame. A new set of 10 pins is set and they are allowed to roll their last bonus ball to be added to their score. The pins knocked down from this last ball are only added as a bonus once to the Strike that was thrown with the first ball in the 10th frame.

**Example:**

In the 10th frame, a bowler scores a strike with their first ball, a strike with their first bonus ball, and 7 pins with their second bonus ball. The points earned from the 10th frame is 27 (10 + 10 + 7).

Task: Write a program that can calculate the cumulative points earned for each frame in a bowling game.

### Score notation for each ball roll:
**X** => Strike  
**/** => Spare  
**-** => Zero Points  
**K** => An integer representing the number of pins knocked down  

**Example Input:**  
Each frame is separated by a space:
```
X X 9- 7/ -1 81 -- 9/ X X7-
```
**Example Output:**
```
29 48 57 67 68 77 77 97 124 141
```
# Input
* Line 1: An integer N specifying the number of games to score
* Next N lines: A string containing 10 frames each separated by a space
# Output
* N lines: Each line contains 10 integers separated by a single space representing the cumulative score for each frame of that game
# Constraints
* 1 <= N <= 10
