# Puzzle
**Another Road Construction Site - 1** https://www.codingame.com/training/easy/another-road-construction-site---1

# Goal
Mario is enjoying a nice ride on a European motorway. The road runs fast, the landscapes follow each other, it's a really nice day!

At one point, however, he encounters a road construction site and has to slow down. No problem Mario, just a few kilometers and you will be free to pick up speed! Ah no, wait, there's another one, slow down again... ugh, still more on the horizon!

How much time do these road construction sites make Mario waste?

# Rules

The exercise provides the distance traveled and a summary of all the construction sites encountered, in the form of the exact kilometer it was encountered and the speed limit to be maintained.

Mario wants to enjoy the ride, but nevertheless always wants to keep the maximum allowed speed.  
For simplicity, let's assume that when the speed limit changes, Mario will adapt his speed instantly.  

Remark: on European highways the standard limit is 130 km/h.  

Let's give an example with a distance of 130 km.  
The unobstructed travel time is 130 km / 130 km/h = 1 h, thus 60 minutes.  

However, there is a road construction site starting at kilometer 60, and Mario must reduce his speed to 120km/h.  
This lasts 70 kilometers, until the end of the road. So we have two sections:  
1) 60 km at 130 km/h => 27.69 minutes  
2) 70 km at 120 km/h => 35.00 minutes  

Ror a total of 62.69 minutes.

The difference to be provided in output is 62.69 - 60.00 = 2.69

Mario lost 3 minutes due to the road construction site!

# Input
* Line 1: An integer roadLength for the total kilometers of the route
* Line 2: An integer zoneQuantity for the number of road construction sites
* Next zoneQuantity lines: Two space separated integers zoneKm and zoneSpeed, respectively for the kilometer in which the road construction site begins, and the relative speed limit in km/h

# Output
* The difference between the theoretical time (without the delays due to construction sites) and the actual travel time.

It must be rounded to the nearest minute (as integer)

# Constraints
* 0 < roadLength < 1000
* 0 < zoneQuantity < 100
* 0 < zoneKm < roadLength
* 0 < zoneSpeed <= 130
