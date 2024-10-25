# Puzzle
**By train or by car?** https://www.codingame.com/training/easy/by-train-or-by-car

# Goal
You are planning a journey from your current city to a destination city.  
This involves selecting which routes to take (some routes may be irrelevant to you), as well as choosing between the train and the car, whichever is faster to reach your destination. Make the right decision according to the following benefits and constraints.

*Train:*  
- Average speed: 284 km/h
- Average speed when crossing a city: 50 km/h at +/-3 km of the city
- Pause at each stop: 8 minutes
- To reach final destination from the final train station : 30 minutes (walk, bus, car...)
- To go from your home to the first train station: 35 minutes (walk, bus, car...)

*Car:*  
- Average speed: 105 km/h
- Average speed when crossing a city: 50 km/h at +/-7 km of the city

*Example:*  
<<Paris ---- 133 km ----> Orléans ---- 218 km -----> Tours>>

*Details by train:*  
- 35 minutes to reach the train station at Paris
- Train starts at 50 km/h for the first 3 km
- Train runs at 284 km/h for the next 127 km
- Train runs at 50 km/h for the 3 km before Orléans
- Train stops at Orléans for 8 minutes
- Train starts at 50 km/h for the first 3 km after Orléans
- Train runs at 284 km/h for the next 212 km
- Train speed decreases to 50 km/h for the last 3 km before arriving at Tours
- 30 minutes to reach your final destination

Time by train => 35 + 3*60/50 + 127*60/284 + 3*60/50 + 8 + 3*60/50 + 212*60/284 + 3*60/50 + 30 = 159.01 minutes (2:39)

*Details by car:*  
- First 7 km at 50 km/h to reach highway
- Average speed of 105 km/h for 119 km to reach Orléans
- To cross Orléans, I drive at 50 km/h for 14 km
- Then average speed of 105 km/h for 204 km to reach Tours
- Arriving at Tours, I drive at 50 km/h for the last 7 km

Time by car: 7*60/50 + 119*60/105 + 14*60/50 + 204*60/105 + 7*60/50=218.17 minutes (3:38)

So it will be faster by train, and the answer is: TRAIN 2:39

# Input
* line 1: starting city destination: starting city is the city where you come from. destination is the city where you want to go.
* line 2: one integer N for the number of lines below following lines: city1 and city2 and distance between the cities in km

# Output
* One line with CAR or TRAIN+duration to go from starting city to destination

# Constraints
* Format for the duration: hh:mm
* All cities will appear only one time as starting point and/or end point. (no loop possible)
* For all tests, there is only one solution.
* values for duration are rounded down: Math.floor() and not Math.ceil()
