# Puzzle
**Particle Detection with Cloud Chamber** https://www.codingame.com/training/medium/particle-detection-with-cloud-chamber

# Goal
A cloud chamber allows scientists to visualize the passage of ionizing radiation such as electrons, protons, alphas, etc.

Every particles should go straight without forces, but a magnetic field bends trajectories of electric charged particles. Then, trajectories of charged particles are (part of) circle.

Our cloud chamber is such that particles can only arrive from top side (other sides are behind thick lead wall), and one at a time.

The aim is to detect which particle has just passed through the cloud chamber.  
The available measurement are:
* V, the speed of the particle (in speed-of-light unit),
* B, the intensity of the magnetic field (in tesla),
* ASCII-art picture of the trajectory of the particle through the cloud chamber (characters are one meter wide and one meter high).

The radius of circle (in meters) of a charged particle is given by
```
R = 1e6 * gamma(V) * m * V / (abs(q) * B * c)
```
Where:
* m is the mass of the particle (in MeV/c²),
* q is the charge of the particle (in unit-charge unit),
* c = 299792458. is the speed of light (in meters per second),
* V is the speed of the particle (in speed-of-light unit),
* B is the magnetic field strength (in tesla),
* gamma(V) is the Lorentz factor (dimensionless), given by
```
gamma(V) = 1 / sqrt(1 - V*V)
```
The radius should be computed from the input ASCII-art picture, then, formula above gives the ratio g = abs(q) / m:
```
g = abs(q) / m = 1e6 * gamma(V) * V / (B * R * c)
```

Thus, the cloud chamber allows only to measure the ratio g = abs(q) / m.  
Mass and charges are given in the table below for every known particles (within this puzzle of course).
```
Particle    Charge    Mass  Symbol
                 q        m       
----------------------------------
Electron        -1    0.511     e- 
Proton          +1  938.0       p+
Neutron          0  940.0       n0
Alpha           +2 3727.0    alpha
Pion π⁺         +1  140.0      pi+
```

The code should return the symbol of the particle and the computed radius (if the particle is not neutral). In experimental physics, we can never get exact numeric values (especially if input data is ASCII-art picture!), therefore, the radius should be given rounded to the nearest multiple of 10.  
Likewise, the ratio g = abs(q)/m could not be computed exactly. Let’s note g_p the theoritical value of particle p (given in the table above) and G the computed value from ASCII-art picture with the formula above.  
The particle p which just passed through the cloud chamber is the one with the minimal value of:
```
abs(g_p - G) / g_p
```
only if this value is stricly below .5, i.e.:
```
abs(g_p - G) / g_p < .5
```
If G is such that
```
abs(g_p - G) / g_p >= .5
```
for every known particles (those in the table above), one can conclude that the particle which just passed through the cloud chamber is unknown (as its value of abs(q)/m is too far from every known particle).

# Input
* Line 1: w width of the picture.
* Line 2: h height of the picture.
* Line 3: B magnetic field (tesla).
* Line 4: V speed of the particle (speed-of-light unit).
* Next h lines: picture : ASCII-art photography of cloud chamber, with space on particle path and # everywhere else.

# Output
Output depends of the nature of the detected particle:  
* symbol inf if neutral particle,
* symbol radius if charged particle,
* I just won the Nobel prize in physics ! if unknown particle.

# Constraints
* 16 ≤ w, h ≤ 128
