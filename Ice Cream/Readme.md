# Puzzle
**Ice Cream** https://www.codingame.com/contribute/view/64827a41f246f46d4b503f926a463bcc1e5db

# Goal
John is trying to buy ice creams to celebrate the success of his new show: Fast and Furious 9 (Reference to meme: Bing Chilling).   
The ice creams come in N blobs with the ith blob of size Ci. But on the way of delivering the ice creams, the ice creams might start to melt! According to his calculation, the meltage of the ith ice cream Si is the volume of his truck minus the size of the ith ice cream. The total meltage (Stotal) of all N ice creams is simply Σ Si (The sum of all Si over all N ice creams).

John brought a new truck with volume T, and he doesn't have more money to buy more trucks, however he could afford to upgrade his truck to change its volume at most K times, and the upgraded truck volume stays that way until it's changed again. Your task is to help John minimize the total meltage of ice creams (Stotal).

Note: In each game turn, you help John decide whether to keep the truck volume unchanged, or to change it to a new volume. The ith game turn corresponds to the ith blob of ice cream.

*Initialization input*  
* Line 1: 2 space-separated integers N, K for the number of blobs of ice creams and the number of times he can upgrade his truck to change its volume respectively
* Line 2: N space-separated integers, the ith integer represents Ci for the volume of the ith ice cream

*Initialization output*  
* An integer representing the initial volume of the truck John brought (This is not predetermined, AKA you can set it to any value you want)

*Input of a game turn*  
* 3 space-separated integers T, U, Stotal for the volume of John's truck, the number of upgrades John has done to his truck and the total meltage of the ice creams respectively

*Output of a game turn*  
* Either "Keep" or "Change Tnew" (without the quotation marks) where Tnew is the upgraded volume for John's truck (This is not predetermined, AKA you can set it to any value you want)

# Constraints
* 1 <= N, K <= 100
* 1 <= Ci <= 109 for all i
