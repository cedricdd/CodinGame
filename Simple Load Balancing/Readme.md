# Puzzle
**Simple Load Balancing** https://www.codingame.com/training/easy/simple-load-balancing

# Goal
In this challenge, you are given N servers. Each server has a current load Li jobs running on it.   
Then a batch k jobs comes and must be distributed on the N servers.   
Your job is to design a program that will distribute the incoming k jobs on the servers such that the difference of the number of jobs in the server with the highest load and the one with the lowest load is minimal. Let’s call this metric Minimal Imbalance.  
For example if we have N=4 and the initial loads as follows [5,0,2,1].   
For k=3 arriving jobs, distributing the jobs to get the following [5,2,2,2] achieves the Minimal Imbalance. The result here is 3 (5-2)  
This challenge was one of the problems in Amazon Last Mile 22.  

# Input
* Line 1: N An integer denoting the number of servers
* Line 2: k An integer denoting the number of jobs to be scheduled
* Line 3: One line containing integers Li where each integer denotes the server current load

# Output
* An integer denoting the minimum achievable imbalance after scheduling the k jobs.

# Constraints
* 1 <= N < 10000
* 0 <= Li <= 10000
* 0 <= k <= 100000000
