# Puzzle
**Mars Colonization** https://www.codingame.com/training/hard/mars-colonization

# Goal
Men are sending robots to Mars as precursors for the final target of colonization.

The robots are called Mobile Construction Vehicles (MCV), that rove on Mars surface to seek suitable stationing sites.   
MCV will deploy itself to become a shelter for all kinds of equipment to establish power, communications, heating, plant cultivation and manufacturing basics by robotic systems. There are multiple MCVs to deploy to form a network of colonies.

Commu links  
It is necessary to keep a communication link between the deployment stations. There are two forms of communication.   
One is by a xG wireless network (evolved from 1G, 2G, 3G...).   
Wireless transmitters are simple and sturdy but have a transmission distance limit, determined by the designed power consumption.   
To standardize the equipment, all MCVs to send to Mars will be equipped with wireless transmitters of the same specification.  

The second communication mode is by satellite microwave transmission.  
Communication by satellites does not have a distance limit but it needs an extra bulky equipment installed in the station.  
Some but not all stations will have satellite transmitters besides the standard wireless transmitters.  

Commu distance  
You, as the network architect, are given a list of planned stationing sites on Mars, denoted by (x,y) coordinates.   
Each site will have a MCV to deploy. The deployment area is carefully chosen to be a flatland so that we assume the land is flat.  

It is not yet confirmed how strong the signal is needed for the wireless transmitters.   
You would like the communication distance be as long as possible. But longer distance causes progressively higher power consumption.   
So, you are asked to determine the minimum distance to conserve energy but still keep all stations linked up according to the deployment plan.  

The baseline is, all stations need to have communication link, directly or indirectly, connected with each others, no matter it is by xG wireless or by satellites or by both.

# Input
* Line 1: M S
* M is the number of stations. It also equals to the number of wireless transmitters.
* S is the number of satellite transmitters among all stations.
* Next M lines: each line will be x y, the coordinates of one spot of deployment. x and y are non-negative integers.

# Output
* Line 1: the minimum wireless transmission distance required for the wireless transmitters, accurate to the nearest 2 decimal places.

# Constraints
* 2 ≤ S ≤ M ≤ 100
* 0 ≤ x, y ≤ 10000
