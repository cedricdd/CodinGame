# Puzzle
**Moving Target** https://www.codingame.com/training/medium/moving-target

# Goal
You want to shoot down an enemy plane flying linearly at constant speed with a big stationary military gun, using a single shot. The plane is currently located at position (pex,pey,pez) and has a velocity vector of (vex,vey,vez). Your gun is positioned at (pgx,pgy,pgz) and can shoot projectiles with a fixed speed of vp at any angle.

Calculate and output the necessary velocity vector (vpx,vpy,vpz) the projectile needs when shot from the gun now in order to hit the plane, as well as the time needed until the hit occurs. The length of that vector must be vp. If it is not possible to hit the plane, output Impossible instead.

The plane never flies directly towards the gun or directly away from the gun.

You can assume that the plane and the projectile fly in a straight line at constant speed. Gravity, air resistance and other factors that could influence the trajectory of the plane or the projectile must be ignored. The gun, the projectile and the plane are modeled as points. The plane is hit if and only if the plane and the projectile happen to be at the same position at the same time.

If there are two valid solutions, output the one with the lower time until impact.

Arm your gun!

# Input
* Line 1: pex pey pez
* Line 2: vex vey vez
* Line 3: pgx pgy pgz
* Line 4: vp

pex, pey, pez: The x, y and z position of the enemy plane in meters (3 space-separated floats)  
vex, vey, vez: The velocity vector of the enemy plane in meters per second (3 space-separated floats)  
pgx, pgy, pgz: The x, y and z position of the gun in meters (3 space-separated floats)  
vp: The velocity of the gun projectile in meters per second (positive float)  

# Output
If there is a solution:  
* Line 1: vpx vpy vpz
* Line 2: time

vpx, vpy, vpz: The velocity vector of the projectile in meters per second (3 space-separated floats)  
time: The time the projectile needs to hit the plane in seconds (positive float)  

Floats must always be output rounded to 4 decimal places and all 4 decimal places must be output (including trailing zeros). For example, +/- 0.12345 is rounded to +/- 0.1235. +/- 0.12344 is rounded to +/- 0.1234.  

If there is no solution:  
* Line 1: Impossible
  
# Constraints
* 0 < vp
* 0 < time
* (pgx,pgy,pgz) does not lie on the line (pex,pey,pez) + t*(vex,vey,vez).
