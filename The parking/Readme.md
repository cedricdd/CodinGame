# Puzzle
**The parking** https://www.codingame.com/training/medium/the-parking

# Goal
You have to calculate the total parking fees and count the number of vehicles which cannot be parked because no empty parking slot is available.

There are 7 car slots and 2 motorbike slots in the car park.  
```
______________________________________________________
|............|............|.............|..MOTORBIKE..
|............|............|.............|-------------
|....CAR.....|....CAR.....|.....CAR.....|..MOTORBIKE..
|............|............|.............|
|............|............|.............|
|
|                                      
|
|
|
|............|............|.............|.............|
|............|............|.............|.............|
|....CAR.....|....CAR.....|.....CAR.....|.....CAR.....|
|............|............|.............|.............|
|............|............|.............|.............|
______________________________________________________
```

Parking is charged at the following rates:  
- 1.2 euros per 15 minutes (note) for cars
- 0.7 euros per 15 minutes (note) for motorbikes
- Free if a vehicle stays for strictly less than 30 minutes
- Full day (a vehicle that is still in the car park at the end of the day) fixed-price: 30 euros  
Note: Parking time is rounded up to the nearest 15 minute interval. For example, the parking fee for 35 minutes is equal to 45 multiplied by the relevant rate.

Example:  
10:00 > C456 M001 M002 M003 means at 10:00 1 car and 3 motorbikes arrive at the car park. Only the car and the 2 first motorbikes will be parked. The third motorbike cannot be parked since there are only 2 motorbike slots.  
11:00 < C456 M001 M002 means at 11:00 the car and the 2 motorbikes leave the car park.  

Output will be:  
```
10.4 0 1
```
- 10.4 is the total parking fees (in euros) for the day, which is the sum of:  
  - parking fee from the car: 1.2 euros * 4 (1 hour = 15 minutes * 4)
  - parking fees from the 2 motorbikes: 0.7 euros * 4 + 0.7 euros * 4
- 0 is the total number of cars which cannot be parked
- 1 is the total number of motorbikes which cannot be parked

# Input
* Line 1: An integer H for the number of lines to read.
* Next H lines: Details of the cars and motorbikes which arrive at or depart from the park in the format of time direction vehicles, e.g. 10:05 > C111 C222 C123 M485 M123.
  * time: in HH:MM 24-hour format
  * direction: > for arrival, < for departure
  * vehicles: list of registration numbers, one for each vehicle. Registration numbers of cars start with C. Registration numbers of motorbikes start with M.

# Output
*total_fees* *cars_not_parked* *motorbikes_not_parked*
* total_fees: total parking fees in euros, shown with 1 decimal place
* cars_not_parked: total number of cars that cannot be parked
* motorbikes_not_parked: total number of motorbikes that cannot be parked

# Constraints
* All the times provided in the input refer to the same day.
* Assume all parking slots are empty at the beginning of the day.
