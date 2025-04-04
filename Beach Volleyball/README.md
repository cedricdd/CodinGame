# Puzzle
**Beach Volleyball** https://www.codingame.com/training/medium/beach-volleyball

# Goal
You love playing beach volleyball! Out there in the sun, playing with your friends, volleying that ball back and forth, it's the best.

Until dude-face comes along, and kicks your precious volleyball into the ocean. You'd kick sand at him, but that volleyball could float away and you have to go get it right away!

You are located on the beach at X=start_x and Y=start_y, and ocean meets the beach where Y=beach_y. The volleyball is located in the water at X=ball_x and Y=ball_y.

You have to plot a route that will take the least time to get the ball. You happen to know that you can travel speed_land units per second on land and speed_water units per second while in the water.

You will travel in a straight line towards the shoreline to coordinate X=beach_x, Y=beach_y, then another straight line from there to the ball.

Find the best integer value for beach_x on the shore line that will result in the least travel time.

# Input
* Line 1: space separated values start_x and start_y
* Line 2: beach_y
* Line 3: space separated values ball_x and ball_y
* Line 4: speed_land
* Line 5: speed_water

# Output
* Line 1 : beach_x - The X coordinate of the point where you meet the beach on your way to the ball.

# Constraints
* 0 ≤ start_x,ball_x ≤ 20,000,000
* 0 ≤ start_y < beach_y < ball_y ≤ 20,000,000
* 1 ≤ speed_water ≤ speed_land ≤ 1,000
