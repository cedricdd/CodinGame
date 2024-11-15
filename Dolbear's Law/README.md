# Puzzle
**Dolbear's Law** https://www.codingame.com/training/easy/dolbears-law

# Goal
Dolbear's law states the relationship between the air temperature and the rate at which crickets chirp (source: Wikipedia).

Dolbear expressed the relationship as the following formula, which provides a way to estimate the temperature TC in degrees Celsius from the number of chirps per minute, called N60:  
TC = 10 + (N60 - 40) / 7.

Another method is to count the number of chirps in 8 seconds, called N8, and add 5 (this is fairly accurate between 5 and 30°C):  
TC = N8 + 5.

We are in August and it is very hot.  
With the help of Jiminy Cricket, you want to estimate the air temperature while staying cool at home.  
You then take a stopwatch, a pencil and a paper, and every 4 seconds, you note the number of chirps of Jiminy.  

For example, if you noted the following series: 3 2 3, then Jiminy chirped 3 times in the first 4 seconds, then 2 times in the next 4 seconds, and finally 3 times in the last 4 seconds.

In order to have a good estimate of the air temperature, you take a lot of measurements: one measure every 4 seconds during M minutes.

Once you're done with the measurements, you can compute the estimated temperature using the correct formula!  
Unfortunately, Jiminy chirps whenever he wants, driving you crazy and distorting your calculations... so do not take your results too seriously!

# Input
* Line 1: an integer M for the number of minutes your measurements lasted.
* Next M lines: series of 15 integers separated by a space, each integer representing the number of times that Jiminy has chirped in 4 seconds (each line thus represents 1 minute).

# Output
* On the first line, you must return the average of the estimates calculated every minute using the N60 formula.
* On the second line, if the result on the first line is between 5 and 30 (inclusive), then return the average of the estimates calculated every 8 seconds using the N8 formula. 

If your total number of measurements is odd, then ignore the very last measure because it makes the total duration of your measurements non-divisible by 8 seconds.

The results must be printed rounded with 1 decimal place:  
16.0 and 16.1 are valid outputs.
16 and 16.12 are invalid outputs.

# Constraints
* 1 ≤ M ≤ 60
* For every measure, 0 ≤ measure ≤ 20
