# Puzzle
**SPORE City Planner** https://www.codingame.com/training/medium/spore-city-planner

# Goal
You are playing the SPORE Galactic Adventures game. https://en.wikipedia.org/wiki/Spore_Galactic_Adventures  
In the Civilization stage and in the Space stage, you can manage your cities using the City Planner.  
Inside each city there are several places (up to 11, depend on the level of the city) for placing objects and one especial place in the city center - the City Hall.  
There are 3 types of objects.  
The House does nothing.  
Entertainment increases the happiness of the city.  
Factory reduces the happiness of the city.  
The City Hall is a House type object and cannot be removed from the city center.  

Some places in the city are connected by roads.  
The road becomes a colored link if the objects are placed both sides of the link.  
Colored links have an effect.  
Blue links (House - Factory) increase the production of the city.  
Green links (House - Entertainment) increase the city's happiness.  
Red links (Factory - Entertainment) decrease the city's happiness.  
White links (between objects of the same type) are neutral.  

You should place objects in the city in order to get the maximum production of the city. But a city cannot have negative happiness.

Example  
City has configuration (1) - - (0) - - (2) - - (3)  
Input for this city are:
```
3
3
0 1
0 2
2 3
```
Placing objects like:
```
1 - Factory
2 - Factory
3 - House
(Factory) - blue - (House) - blue - (Factory) - blue - (House)
```
gives 3 production (3 blue links)  
but have -2 happiness (two Factories)  
```
(-1) - - (0) - - (-1) - - (0)
```
This placement is not acceptable.

Correct placement is:
```
1 - Entertainment
2 - Factory
3 - House
(Entertainment) - green - (House) - blue - (Factory) - blue - (House)
```
gives 2 production (2 blue links)  
and have +1 happiness (1 Entertainment + 1 green link - 1 Factory)  
```
(1) - 1 - (0) - - (-1) - - (0)
```
So, answer for this city is 2

# Input
* Line 1: An integer N for the number of places inside the city (City Hall not included to N).
* Line 2: An integer L for the number of links.
* Next L lines: Two space separated integers A and B (from 0 to N) - two node numbers for describe Link. Place 0 means City Hall.

# Output
* The maximum possible value of city's production.

# Constraints
* 1 < N ≤ 11
* 0 ≤ A,B ≤ N
