# Puzzle
**Firewall placement** https://www.codingame.com/training/medium/firewall-placement

# Goal
A virus is installed in one of the nodes of a network.   
The goal is to protect the largest possible part of the network from the virus by placing a firewall on a single node that the virus cannot traverse.  
You must output the optimal location of the firewall. You cannot place your firewall on an infected node.  

NOTE: The virus can spread through any link in the network. Solutions are unique, no tiebreaking is needed.  

# Input
* Line 1: An integer, numNodes, the number of nodes in the network
* Line 2: An integer, virusLocation, the starting node of the virus
* Line 3: An integer, numLinks, the number of links within the network
* Next numLinks lines: Two space-separated integers i and j representing the indexes of the nodes connected by the undirected link

# Output
* An integer firewallLocation, the index of the node where the firewall should be placed.

# Constraints
* 5 <= numNodes <= 500
