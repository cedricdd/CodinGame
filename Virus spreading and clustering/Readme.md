# Puzzle
**Virus spreading and clustering** https://www.codingame.com/training/medium/virus-spreading-and-clustering

# Goal
Given a population size and a network of connections between its members, determine the breakdown of cluster sizes of the population.

Imagine that each member of a population is one person. Now consider that one member of the population becomes "infected" by a virus.   
Provided a set of connections (i.e. "member A is linked to member B"), the subset of members of the population infected by the virus can be simulated (we will assume that transmission is guaranteed to occur between linked members). This subset is effectively like an "outbreak" of a virus.

Your job is to assess these subsets, or clusters and provide the breakdown of the distribution of cluster sizes in the given population.

NOTE: All links are two-way (reciprocal), there are no one-way links.

Given a population size N, with members indexed from 0 to N-1, calculate the size of every outbreak/cluster within the population.

# Input 
* Line 1: A number, N, of members of the population
* Line 2: A number, L, of links within the population
* Next L lines: Two space-separated integers representing the indexes of two linked members of the population

# Output
* "cluster size" and "cluster count" for each cluster, separated by a space; in descending order of size.

# Constraints
* 5 <= N <= 500
* 800 > L
* Every member of the population belongs to a cluster even if its size is of 1 (a cluster with only one member).
