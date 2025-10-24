# Puzzle
**Thomas and the Freight Cars** https://www.codingame.com/training/hard/thomas-and-the-freight-cars

# Goal
Thomas is a tank engine. He received an order to pull a train of freight cars to the next town.   
He is waiting at the train station for the cars to link up.

Individual freight cars are moving into the train station in a predetermined order.   
Thomas wants to pull a train such that the heaviest load should be in the first car. The lighter the cars the rearer they should be arranged.  
Thomas said this is the most stable train arrangement.

When a car arrives, it can be added to the front or the rear of the train of cars. (The first car to add will become the first single car in the train.)   
Or, a car can be diverted to another station without adding it at all. Thomas need not pull all the cars. His friends can help pull the rest.

Once linked up, it is impossible to insert a car to the middle of a train. Neither is it possible to unlink a car to relocate.

Thomas wants the resulting train be as long as possible but the cars must be sorted by weight. Tell Thomas how long the train of cars will be.

*Example*  
5 freight cars of different weights come in this sequence (the numbers are their weights):
```
4 5 1 3 2
```
4 comes, the train will be 4  
5 comes, add to front. The train will be 5 4  
1 comes, discard  
3 comes, add to rear. The train will be 5 4 3  
2 comes, add to rear. The train will be 5 4 3 2  

The train will have a length of 4, which happens to be the longest possible length.

# Input
* Line 1: An integer N for the number of freight cars to come
* Line 2: N integers separated by space, for the weight of each freight car in the order they are coming to the station.
* No two cars have the same weight.

# Output
* Line 1: The number of cars in the longest train that can be formed from the coming car sequence, under the conditions described above.

# Constraints
* 1 ≤ N ≤ 100
* 1 ≤ weight of a car ≤ 1000
