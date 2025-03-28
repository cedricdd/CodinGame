# Puzzle
**Furlongs per Fortnight** https://www.codingame.com/training/easy/furlongs-per-fortnight

# Goal
Most of the world uses the "metric system" but the United States still uses the "imperial system" which has all sorts of interesting units of distance (some more common than others)

Speed is simply some-distance per some-time

*Your task:*  
This puzzle inputs a inputSpeed expressed in dist1(unit of distance) per time1(unit of time)  
Your challenge is to convert that to another dist2(unit of distance) per time2(unit of time)

*Units of distance:*  
* 1 mile = 8 furlongs
* 1 furlong = 10 chains
* 1 chain = 22 yards
* 1 yard = 3 feet
* 1 foot = 12 inches

*Units of time:*  
* 1 fortnight = 2 weeks
* 1 week = 7 days
* 1 day = 24 hours
* 1 hour = 60 minutes
* 1 minute = 60 seconds

*In a speed expression:*  
* a distance uses its plural version, such as yards, feet, inches (except for the rare occasion when the speed is exactly 1, which this puzzle doesn't include)
* a time uses its singular version, such as hour, minute

# Input
* A string: inputSpeed dist1 per time1 CONVERT TO dist2 per time2 where inputSpeed is an integer and the rest are strings

# Output
* A string: convertedSpeed dist2 per time2 where convertedSpeed is a float rounded to nearest 1/10
