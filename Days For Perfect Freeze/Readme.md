# Puzzle
**Days For Perfect Freeze** https://www.codingame.com/contribute/view/843304a4c481d87e2055f23eee03859928d67

# Goal
Cirno is an ice fairy who lives in Misty Lake, and as an "idiotic" fairy, there is always a lot of free time for her to play every day. Daiyousei, as her friend, wanted to find out the regularity of her playing actions in the following days. She observed Cirno for days, and found that:

Cirno has a special rule for her to choose the way to entertain:  
* Cirno has two ways of recreation: Freeze the Frog or Swim in Lake.
* In the first day she started observing, Cirno told her that she randomly (1/2 for each of the two ways) chose a way to entertain.
* And in the other days, Cirno had formed a perference to the entertainments:

If she freezes a frog on a day, she has a probability of probabilityStayF to keep freezing frogs the next day, and (1 - probabilityStayF) to change to swimming the next day.  
The same as probabilityStayF, probabilityStayS describes the action in the next day after she swims.

Daiyousei was so proud of her findings, until she found that she forgot to record the days Cirno Freeze the Frog in the totalDays she has observed. Help her to estimate the days!

# Input
* Line 1: An integer totalDays for the total days Cirno played (Daiyousei observed).
* Line 2: A float probabilityStayF indicates the probability for Cirno to keep freezing frogs in the next day.
* Line 3: A float probabilityStayS indicates the probability for Cirno to keep swimming in the next day.

# Output
* An integer for the EXPECTED value of the days that Cirno played Freeze the Frog.
* Tips: In most cases the expected value is not an integer. In this case the fractional part is discarded.

# Constraints
* 2 ≤ totalDays ≤ 1000
* 0 ≤ probabilityStayF ≤ 1
* 0 ≤ probabilityStayS ≤ 1
