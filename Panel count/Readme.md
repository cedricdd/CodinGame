# Puzzle
**Panel count** https://www.codingame.com/training/easy/panel-count

# Goal
Goal: count the number of persons matching some formulas.

*Input:*
- The properties of the persons (e.g. Age, Gender).
- A list of persons. Each one is identified by a name and its space-separated properties (e.g. John 25 London).
- A list of formulas. Each formula is a combination of properties, and is used to filter the matching persons (e.g. Town=Paris AND Gender=Male)

*Output:*  
For each formula, filter the matching persons and print their count.

Example : Gender=Male AND Age=25 AND Town=Berlin. The expected output is the number of 25yo men living in Berlin.

Note : each formula has a variable number of properties.

# Input
* First Line : number P of properties.
* P next lines : the name of each property (ex : Gender, Age, Town).
* Next line : number N of persons.
* N next lines : one person per line, with a name followed by the properties (ex : Jean Male 25 Paris).
* Next line : number F of formulas.
* F next lines : one formula per line, following this syntax : propertyX=valueA AND propertyY=valueB ...

# Output
* F lines (one for each formula) : print the number of persons matching this formula.

# Constraints
* 1 ≤ P ≤ 10
* 1 ≤ N ≤ 1000
* 1 ≤ F ≤ 300
