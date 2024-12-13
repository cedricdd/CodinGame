# Puzzle
**IP mask calculating** https://www.codingame.com/training/medium/ip-mask-calculating

# Goal
Given an IP address and a mask in CIDR format you must output the network address and the broadcast address.

The IP address is the address of a computer on a network. In an IP address there are two parts, the network part and the machine part.  
We can separate the two parts with the mask.

The mask is, in binary, a continuous part of 1s flowing by a continuous part of 0s. It can't be a mixture of 1 and 0.

To know the network address of an IP we proceed like this:  
For the entry 192.168.0.15/24, the machine IP is 192.168.0.15 and the mask part is 24.

The mask part means the first 24 bits in the mask are set at 1 and the last ones are set to 0:  
The mask is 11111111.11111111.11111111.00000000  
In integers that corresponds to 255.255.255.0  

To know the network address we take all bits with a 1 in the mask:  
192.168.0.15 is in binary  
11000000.10101000.00000000.00001111  
11111111.11111111.11111111.00000000 -> is the mask in binary  
Now the network part of the IP address is:  
11000000.10101000.00000000  
After, we place all 0 we need to get a total of 32 digits  
The network address is now  
10000000.10101000.00000000.00000000  
In integer that means  
192.168.0.0  

The broadcast address is the network address with all bits in machine part set to 1.

If we take the same example we got this  
192.168.0.15 is in binary  
11000000.10101000.00000000.00001111  
11111111.11111111.11111111.00000000 -> is the mask in binary  
The broadcast address is:  
11000000.10101000.00000000.11111111 -> in integer that means 192.168.0.255.  

# Input
* A ip address and a mask in CIDR format.

# Output
* The network address and the broadcast address on two different lines.

# Constraints
* All entries can be calculated.
