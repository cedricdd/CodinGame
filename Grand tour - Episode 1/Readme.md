# Puzzle
**Grand tour - Episode 1** https://www.codingame.com/contribute/view/775321d352fa17363836e2bd5eccd79552568

# Goal
Millions of cars are taking part in a grand tour (race really) around the entire continental United States. But who will win? This puzzle will tell us.

*Gory details:*  
There is a grand race being organized. Several million cars are taking part in the race. The starting location, the path, and the finish location are not important here.  
The road is very wide, and there is no speed penalty when drivers overtake one another. Every car has a known constant speed and it will drive start to finish at exactly that speed.   
All cars start at the exact same moment and have the exact same distance to travel. Therefore, the fastest car in the race is for sure going to finish first in the race, the second fastest will be second, etc.

The organizers imposed some safety limitations. The maximum speed is 99 km/hour. So all cars will have a speed ranging from 1 (they are barely able to move) through 99 (safety issues, you see).   
For simplicity, speeds are integral values.

Organizers are not really concerned who is who, and therefore the cars do not have any sort of IDs. The output shall depend only on cars' speeds and that is it, no owners' names and no cars' plates either.  
Cars with equal speed are considered indistinguishable in every way. 

For obscure technical reasons, the car speed is not provided explicitly in the input data, rather it is generated with a RNG. Here are the rules:  
* RNG(0) = rng_seed  
* RNG(for n in 1..N) = (RNG(n-1) * rng_a + rng_b) mod (2**32)  
* SPEED(for n in 1..N) = RNG(n) mod 99 + 1    /input, speed of each car/  

For even more obscure technical reasons, the speeds are not going to be outputted explicitly either. Rather, they are going to be hashed into an aggregate value:
* BESTSPEED(1) is the speed of the fastest car
* BESTSPEED(N) is the speed of the slowest car
* AGGREGATE(0) = rng_seed
* AGGREGATE(for n in 1..N) = (AGGREGATE(n-1) * n + BESTSPEED(n)) mod (2**32)
* AGGREGATE(N) the last value in sequence is the output

*The difficult part:*  
* Most standard libraries have quicksort implemented, but it may not be fast enough. It goes even worse than that. The best comparison-based sorting methods *cannot* and I really mean *cannot* go faster than O(n log n) on average. You need to look into non-comparison sorting methods.

*The easy part:*  
* The speed of each car is severely limited. This enables you to do certain ways of sorting which are not possible with larger values.

Example

Input:
```
10
209 6878 5043
```

Debug output:
```
> RNG(1) = 1442545
> RNG(2) = 1331894961
> RNG(3) = 3903271729
> RNG(4) = 3157357105
> RNG(5) = 947524657
> RNG(6) = 1609207857
> RNG(7) = 923697
> RNG(8) = 2058225713
> RNG(9) = 264251441
> RNG(10) = 750250033
> SPEED(1) = 17
> SPEED(2) = 46
> SPEED(3) = 17
> SPEED(4) = 2
> SPEED(5) = 14
> SPEED(6) = 82
> SPEED(7) = 28
> SPEED(8) = 72
> SPEED(9) = 48
> SPEED(10) = 17
> BESTSPEED(1) = 82
> BESTSPEED(2) = 72
> BESTSPEED(3) = 48
> BESTSPEED(4) = 46
> BESTSPEED(5) = 28
> BESTSPEED(6) = 17
> BESTSPEED(7) = 17
> BESTSPEED(8) = 17
> BESTSPEED(9) = 14
> BESTSPEED(10) = 2
> AGGREGATE(1) = 291
> AGGREGATE(2) = 654
> AGGREGATE(3) = 2010
> AGGREGATE(4) = 8086
> AGGREGATE(5) = 40458
> AGGREGATE(6) = 242765
> AGGREGATE(7) = 1699372
> AGGREGATE(8) = 13594993
> AGGREGATE(9) = 122354951
> AGGREGATE(10) = 1223549512
1223549512
```

# Input
* Line 1: Integer N /how many cars participate/
* Line 2: Integers rng_seed rng_a rng_b /for generating both input and output/
* On line 2 the integers are space separated.

# Output
* Line 1: Integer /speeds aggregate/

# Constraints
* N is either 10 (ten), 1000 (a thousand), 1M (a million), or 2M (two million) depending on the test case.
* rng_seed rng_a rng_b are all 32-bit unsigned integers between 100 and 10000.
* All the operations on them should also happen with 32-bit unsigned integers.
