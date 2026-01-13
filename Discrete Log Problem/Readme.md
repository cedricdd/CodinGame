# Puzzle
**Discrete Log Problem** https://www.codingame.com/training/hard/discrete-log-problem

# Goal
ElGamal encryption is a public-key cryptosystem. It uses asymmetric key encryption for a safe communication between two people.

Let us assume that Alice wants to communicate with Bob. Alice generates three large random integers:  
- Q a prime used as the order of the key
- 0 < G < Q a generator
- X Alice's secret key

Alice computes H = G^X mod Q and publicly shares with Bob the public key (G, H, Q). As an attacker, you intercept this key and decide to spy on their communications. To do so, you need to find Alice's secret key X. This can be done by performing a discrete logarithm attack on this key.

Given the public key (G, H, Q), you are asked to perform this attack: find the lowest integer X such that G^X mod Q = H.

The rest of this protocol is not explained to avoid overload but it can be found on https://en.wikipedia.org/wiki/ElGamal_encryption

# Input
* Line 1: The public key (G, H, Q)

# Output
* Line 1: Alice's private key X.

# Constraints
* 1 < G, H < Q
* 1 < X < Q-1.
* 0 < Q < 50.000.000.000
