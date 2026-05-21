# Puzzle
**Jump the Queue** https://www.codingame.com/contribute/view/1480538610c42be57278e5840099e794c0a406

# Goal
A school of students is queueing in line in the school canteen to buy lunchboxes.  
There is only one counter serving one queue.  

When a student comes and wants to join the queue, he will search the queue from head to tail to check if any of his friends are already in the queue. If any friend is found, he will jump the queue to insert himself right behind his friend group in the queue. If no friend is found, he will join the queue at the tail.

Assume all students do join the queue in this manner. Write a program to simulate the working of this queue.  

# Input
* Line 1: Two space-separated integers g e, g refers to how many groups of friends are in the school. e is the number of events going to happen.
* Next g lines: Each line is a list of students belonging to the same friend group. Students are represented by their unique student IDs, space-separated integers. Each student belongs to no more than one friend group. There could be some students having no friends in the school, and these lonely wolves are not listed in the friend groups (but they still need to buy lunchboxes).
* Next line is a sequence of e integers, space-separated. Each integer represents an event. When it is a positive number, it is an Enqueueing event. The student with this ID number is joining the queue in the manner described above. When the number is -1, it is a Dequeueing event. The student at the head of the queue has bought his lunchbox and is leaving. All events happen sequentially in the order shown in the line.

# Output
* When a dequeueing event happens, write the ID of the student who is leaving the queue. Write each ID in its own line.

# Constraints
* 1 ≤ g ≤ 100
* 1 ≤ e ≤ 1000
* 1 ≤ ID ≤ 100000
* 2 ≤ size of each friend group ≤ 100
* There will always be at least one dequeueing event.
* The given events are assured to be physically reasonable - no dequeueing will happen when no one is queueing, and a student will not enqueue again before dequeueing.
