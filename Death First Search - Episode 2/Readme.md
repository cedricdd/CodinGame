# Puzzle
**Death First Search - Episode 2** https://www.codingame.com/training/hard/death-first-search-episode-2

# Goal
Bobnet is responding to your intrusion and has activated additional defenses:
- Most of the links have been reinforced: your virus no longer has the possibility to destroy a link between two ordinary nodes, it can now only sever links leading to gateways. If it attempts to cut a link between two ordinary nodes it will be detected and deleted.
- Nodes may now be connected to up to two gateways!

Your virus has caused a backdoor to open on the Bobnet network enabling you to send new instructions in real time.

You decide to take action by stopping Bobnet from communicating on its own internal network.

Bobnet's network is divided into several smaller networks, in each sub-network is a Bobnet agent tasked with transferring information by moving from node to node along links and accessing gateways leading to other sub-networks.

Your mission is to reprogram the virus so it will sever links in such a way that the Bobnet Agent is unable to access another sub-network thus preventing information concerning the presence of our virus to reach Bobnet's central hub.

# Input
* The program must first read the initialization data from standard input. 
* Then, within an infinite loop, read the data from the standard input related to the current state of the Bobnet agent and provide to the standard output the next instruction.


* Line 1: 3 integers N L E
  - N, the total number of nodes in the level, including the gateways.
  - L, the number of links in the level.
  - E, the number of exit gateways in the level.

* Next L lines: 2 integers per line (N1, N2), indicating a link between the nodes indexed N1 and N2 in the network.

* Next E lines: 1 integer EI representing the index of a gateway node.

*Input for one game turn*  
* Line 1: 1 integer SI, which is the index of the node on which the Bobnet agent is positioned this turn.

*Output for one game turn*  
* A single line comprised of two integers C1 and C2 separated by a space. C1 and C2 are the indices of the nodes you wish to sever the link between.
