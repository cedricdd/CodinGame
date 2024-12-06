# Puzzle
**Gravity Tumbler** https://www.codingame.com/training/medium/gravity-tumbler

# Goal
The program must output the result of tumbling a landscape a certain number of times.

*Tumbling entails:*  
* rotating the landscape counterclockwise by 90°
* letting the hash bits # fall down

The map is composed of . and #.

(This puzzle is a twist (hah!) on classic community puzzle “Gravity”. You may want to solve that one first.)

# Input
* Line 1: two space-separated integers: the map width and height
* Line 2: the number count of tumbling actions to perform
* Next height lines: width characters (empty bits . and heavy bits #)

# Output
* If count is odd: width lines of height characters.
* If count is even: height lines of width characters.

Obviously, in both cases, the # are at the bottom.

# Constraints
* 0 < width < 100
* 0 < height < 10
* 0 < count < 100
* The input map is in a “stable” configuration, i.e. the heavy bits are already at the bottom.
