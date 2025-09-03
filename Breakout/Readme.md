# Puzzle
**Breakout** https://www.codingame.com/training/hard/breakout

# Goal
Bricks of 100 x 30 pixels are arranged in a playfield of 1600 x 2400 pixels (origin at the top-left). A dimensionless point (the ball) bounces around the playfield, breaking bricks as it hits them. Each broken brick scores points.

The ball will bounce off of:
- The left, right, and top of the playfield
- Any side of any brick
- The top of a 200 x 3 pixel mobile paddle

All bounces are treated classically. The accidental angle is equal to the incidental angle. So, for example, if the ball's vector is (vX, vY) = (10, 10) (moving down and right), and the ball hits the top of a brick, then the resulting ball vector will be (10, -10), and if the ball then hits the right-hand wall, then the resulting vector would be (-10, -10).

You don't need to worry about what happens if the ball hits the corner of something. The tests are engineered to avoid this situation.

Each brick has an associated kStrength value, indicating the "strength" of the brick. A brick with a strength of 1 will break and disappear after a single hit from the ball. A brick with a strength of 2 requires 2 hits before it breaks. No points are awarded for hitting a brick until it breaks and disappears.

For many of the tests, the paddle is stationary, but in some of the latter tests, the paddle can move around the playfield to keep the ball in play. Multiple coordinate sets are provided to specify the various locations of the paddle throughout the test. The paddle "moves" to the next coordinate set after being hit by the ball. If there are no other coordinate sets provided in the input, then the paddle doesn't move for the rest of the test, and remains at the last specified position.

The ball is lost if it goes off the bottom of the playfield. Your program must calculate and report points acquired by breaking bricks before the ball is lost.

# Input
* Line 1: Two space-separated integers bX and bY indicating the starting position of the ball.
* Line 2: Two space-separated integers vX and vY indicating the starting vector of the ball.
* Line 3: An integer pN indicating the number of positions that will be occupied by the paddle during the game.
* Line 4: An integer kN indicating the number of bricks initially on the playfield.
* Next pN lines: Two space-separated integers pX and pY for the coordinates of the top-left-hand pixel of the paddle.
* Next kN lines: Four space-separated integers kX, kY, kStrength, kPoints for the coordinates of the top-left corner of the brick, the strength of the brick, and the number of points earned for breaking the brick.

# Output
* The number of points earned before the ball is lost.

# Constraints
* 0 ≤ bX < 1600
* 0 ≤ bY < 2400
* -100 ≤ vX ≤ 100
* -100 ≤ vY ≤ 100
* 1 ≤ pN ≤ 32
* 1 ≤ kN ≤ 64
* 0 ≤ pX ≤ 1400
* 2200 ≤ pY ≤ 2300
* 0 ≤ kX ≤ 1500
* 0 ≤ kY ≤ 1500
* 1 ≤ kStrength ≤ 5
