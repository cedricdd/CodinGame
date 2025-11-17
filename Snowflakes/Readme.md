# Puzzle
**Snowflakes** https://www.codingame.com/contribute/view/13676715255ff2a4dc23f9feea4d726aa686ea

# Goal
There is a saying that no two snowflakes are alike, but you are skeptical of this claim. On a snowy day, you take a photo of the sky to test this claim. The goal is to find out how many total snowflakes are in the photo and how many of them are unique shapes.

Photo:  
A photo is a 2D grid representing a snapshot of the sky. Each cell contains either: an asterisk (*) representing part of a snowflake, or a fullstop (.) representing empty sky.

Snowflakes:  
Snowflakes are formed from one or more connected asterisks (*) which are horizontally or vertically adjacent. Asterisks that touch only diagonally are NOT connected and therefore belong to separate snowflakes.

Two snowflakes are considered to have the same shape if one can be transformed into the other by any combination of rotation (any multiple of 90°) and/or mirror reflection.

Example of the same snowflake shape in different orientations:
```
**. *** ..* ... .** *** *.. ...
*.. ..* ..* *.. ..* *.. *.. ..*
*.. ... .** *** ..* ... **. ***
```

# Input
* Line 1: Space separated integers representing the hight and width of the photo, in the form: h w
* Next h Lines: String of length w representing a row of the photo.

# Output
* Line 1: Integer of the total number of snowflakes.
* Line 2: Integer of the number of distinct snowflakes shapes.

# Constraints
* 1 ≤ h, w ≤ ?
