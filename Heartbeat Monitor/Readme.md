# Puzzle
**Heartbeat Monitor** https://www.codingame.com/contribute/view/94825217a546a662b579e6e028fab94e791ca

# Goal
You are presented with an ECG scan of a singular heartbeat. Your task is to guess which heart condition the patient has. Keep in mind that the patient could also be healthy and have no disease.

The input is a series of numbers representing the intensity, in millivolts (10⁻³ Volts, abbreviated as mV below), of the electrical pulse. Each number is measured exactly five milliseconds after the previous one. The first measurement is taken at time 5ms.

*The pulse*  
The pulse, for the sake of this puzzle, is composed of 6 components:
The P-wave, the PR segment, the QRS complex, the ST segment, the T-wave and the Idle interval.  
Each section is divided when the intensity of the pulse reaches exactly 0 mV.  

- The P-wave is a depolarization of the atria. It goes up and down once.
- The PR segment is the interval between the last part of the P-wave and the QRS complex. It is usually flat and its intensity is 0.01 mV.
- The QRS complex corresponds to a quick depolarization of the right and left ventricles.
It goes up and down linearly, its intensity is not relevant for this puzzle.
- The ST segment is the interval between the last part of the QRS complex and the T-wave. It is usually flat and its intensity is 0.01 mV.
- The T-wave represents the repolarization of the ventricles. It goes up and down once.
- The Idle interval is simply the part before the P-wave of the next heartbeat. Its intensity is 0.01 mV.

*Heart conditions*  
An abnormality in one or more of these components corresponds to a specific heart condition. The ones that the program should be able to recognize are:

*Atrial Fibrillation*  
Characterized by fluctuations in the P-wave, the PR segment the ST segment and T-wave

*Atrial Stand Still*  
Characterized by absence of P-waves

*Wolff Parkinson White Syndrome*  
Characterized by a QRS complex with duration greater than 110 ms

*Myocardial Infarction*  
Characterized by T-waves with intensity over 0.6 mV

*Hyperkalemia*  
Characterized by T-waves with intensity over 0.6 mV, QRS complex with duration greater than 110 ms and flattened or absent P-waves.

*Short P*  
Characterized by short P-waves with duration less than 60 ms

*Asystole*  
Characterized by a flat ECG with intensity of 0 mV

In order to measure the length of a section, such as the QRS complex, zeroes should not be included. Simply take the length of the section and multiply it by five.

The program should print the condition of the patient or, if the ECG doesn't present any signs of cardiac anomaly, print Normal and the BPM (beats per minute) of the patient.

The BPM should be calculated by considering the length of the full input, zeroes included. You can assume that all the following heartbeats will have the same length.

# Input
* Line 1: a number n representing the number of measurements done
* Line 2: a series of n integers v separated by spaces representing the ECG values in 10⁻⁵ Volts

# Output
* Line 1: the condition of the patient or Normal BPM

# Constraints
* 0 <= n <= 300
* -100 <= v <= 100
