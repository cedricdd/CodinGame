# Puzzle
**Pandora's Bridges** https://www.codingame.com/contribute/view/1125124d840255a7846f001fd017947c5535b8

# Goal
Pandora is in crisis!  
The Ikrans have been eradicated by the Sky People in an attempt to gain the upper hand in their invasion. Pandora is a world full of floating islands and the Ikrans were the Na'vi's only way of navigating between them. It's imperative that the Na'vi can travel between all the islands. The Na'vi have only one option and must fell trees and use the wood for bridges between the islands. However, there is a problem... Trees are sacred to the Na'vi and cutting them down is the last thing they want to do.

The goal is to find the MINIMUM length of wood required to connect ALL the islands together AND complete this using the MINIMUM number of trees.

*Coordinates:*  
Coordinates are provided in units of Pandorian meters, where a difference of 1 in any axis (x, y, or z) corresponds to a distance of 1 Pandorian meter. These coordinates represent the location of the Tree of Voices on each island. Any bridges made to an island must connect to this location.

*Connecting Islands:*  
Na'vi are primitive and they have not yet been able to master carpentry or civil engineering. Therefore, islands can only be connected to one another if the distance between them is LESS THAN OR EQUAL to the tree length. All trees on Pandora are of a uniform length of 1000 Pandorian meters. Although wood cannot be combined, it can, through an ancient technique, be cut into two pieces of variable lengths with perfect precision.

Na'vi are fantastic climbers but unfortunately the children are still learning. Therefore, each bridge must be walkable. A bridge is considered walkable if the angle between the islands is LESS THAN OR EQUAL to 45 degrees. Any angles should be rounded to 2 decimal places (d.p.).

Two islands are considered to be connected if there exists ANY path between. This includes either a direct bridge between them or through an indirect connection using the bridges of other islands.

*Leftover Wood:*  
After a tree is felled, it can be cut to the exact required length for a bridge. The unused portion is considered leftover wood. The Na'vi aim to use any leftover wood, from previous bridges, to reduce the number of additional trees that need to be felled.

*Connecting to the Ground:*  
The Na'vi need to be able to access the islands from the ground. Ensure the islands connect AT LEAST ONCE to the Hometree at position: x = 1, y = 1, z = 1.

# Input
* Line 1: Integer n representing the number of islands.
* Next n lines: Space separated string representing 3D coordinates of an island's Tree of Voices, in the form: x y z (all floats)

# Output
* Line 1: Float of total distance of wood required to connect all islands (rounded to 2 d.p.)
* Line 2: Float of total length of wasted wood (rounded to 2 d.p.)
* Line 3: Integer of the number of trees used.

# Constraints
* 1 ≤ n ≤ 250
* -3000 ≤ x, y ≤ 3000
* 1 ≤ z ≤ 5000
