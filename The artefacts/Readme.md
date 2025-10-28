# Puzzle
**The artefacts** https://www.codingame.com/contribute/view/624183ff6ab96329ec1deefef233fd2457f83

# Goal
The green wizard has to collect the artefacts needed for his spell. They are hidden in a dense forest, and he asked for your help to find and get them.   
He gives you one of his magic spyglasses to help you locate them.  
You climb a hill nearby and can see the position of each artefact.  

The wizard has an infinite amount of time at his disposal, but he wants to minimize the total length of the paths he paves in the forest to collect the artefacts (he can then follow those paths as many times as necessary). He asks you to find the best route to collect them all in the given order.

You must give the green wizard the instructions to find all the artefacts in the minimum total length of path paved.   
Instructions must guide him from the hill to the first artefact, then from the first one to the second one, etc and from the last artefact back to the hill where you are.  
The wizard can only pave straight paths between two positions where artefacts are (or were before).  
You can revisit the position of an artefact after collecting it.  

Use euclidean distance. For example, the distance from A to B here is √(3² + 1²) ≈ 3.16 (3 steps east, 1 step south)
```
A _ _ _
_ _ _ B
```
Note : The distance instructions (steps N/S and E/W) are just to help the wizard locate the artefact. He will still pave a straight "diagonal" way.

Instructions are of the following form :
- Go to symbol_of_artefact : x N/S y E/W : Go in a straight line to the symbol symbol_of_artefact, which is x steps North (or South) and y steps East (or West).  
If it is not necessary to travel N/S (respectively E/W), omit this part. Omit both when the position of the artefact has already been visited.
- Go to Hill : Go in a straight line to the hill (which can be seen from anywhere, so you don't need to specify the way).
- Collect name_of_artefact : Collect the artefact where you are. You must collect them in the given order, but you can pass by an artefact that cannot yet be collected, while travelling to another artefact.

If you don't know where to start, have a look at Minimum spanning trees : https://en.wikipedia.org/wiki/Minimum_spanning_tree

# Input
* First line : 3 space-separated integers n, the number of artefacts, w and h respectively the width and length of the forest.
* n next lines : space-separated, symbol_of_artefact and name_of_artefact, the symbol of an artefact (one character) followed by its name (may contain spaces)
* h next lines : a string of length w representing the map of the forest. It may contain any ascii character.

# Output
* On the first line, an integer, the total distance of path to pave rounded up to the nearest integer.
* On the following lines, the instructions to collect all the artefacts in the given order, starting from the hill and finishing on the hill.

# Constraints
* 1 ≤ n ≤ 10
* 3 ≤ w, h ≤ 100
* The first row of the map is the northernmost one.
* Every artefact symbol, and the hill, can be found exactly once in the map. The hill will always be represented by the hash character : #.
* There is only one solution to minimize the total distance while paving paths.
