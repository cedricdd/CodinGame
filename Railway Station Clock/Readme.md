# Puzzle
**Railway Station Clock** https://www.codingame.com/training/medium/railway-station-clock

# Goal
The old clock in the railway station is too ancient to be refurbished but too nice to be replaced with a modern one.  
But it is a little slow. To be precise, every four minutes it goes behind by one more second.  

The clock is stable in its delay. In addition the station administrator adjusts the clock daily at 8AM.  
So it's not that bad.  
But still all the train events recorded in the official station log are timewise wrong.  

You need to create a script to recover true times having times observed from the station clock as input.

Please note, you don't need to worry about fractions of a second (all tests are guaranteed to have whole seconds for both observed and true times).

# Input
* A line containing time observed from the clock in the form: HH:MM:SS PP

# Output
* A single line with respective true time in the form: HH:MM:SS PP

# Constraints
* time as well as true time is 12-hour time from 12:00:00 AM to 11:59:59 PM.
* If hour is less than 10 then no leading zero is used, e.g. 6:30:00 PM
