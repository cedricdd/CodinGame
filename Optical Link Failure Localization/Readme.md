# Puzzle
**Optical Link Failure Localization** https://www.codingame.com/training/medium/optical-link-failure-localization

# Goal
Monitoring trails (m-trails) can instantaneously detect single and dual link failures in optical communication networks. An m-trail is an optical light-path, i.e., a laser transmits a light beam on a given wavelength at the start node S, the beam is traversing optical links l_i while it reaches a photo detector at the end node D of the m-trail.

The traversed links l_i by m-trail m_j are stored in the link code matrix: entry (i,j) is 1 if the m-trail m_j traverses link l_i, and 0 otherwise.

At the photo detector for m_j we know that: 1) if the light beam arrives all links along m_j are operational, 2) if there is no light then at least one link failed along the path of m_j. The photo detector j generates an alarm signal for m_j if it does not receive the light. The network manager collects all alarm signals to an alarm code vector, where 1 denotes an alarm was received from m_j, otherwise 0.

Our task is to identify the failed links (at most two) from the alarm code vector for a given link code matrix.

*Example:*  
```
M-trails:
m_0: S --- l_0 --- l_1 --- l_2 --- l_4 --- D
m_1: S --- l_2 --- l_3 --- l_4 --- D
m_2: S --- l_1 --- l_4 --- D
```
*The corresponding link code matrix:*  
```
    m_0   m_1   m_2
l_0  1     0     0
l_1  1     0     1
l_2  1     1     0
l_3  0     1     0
l_4  1     1     1
```

Alarm code vector: 110

If there can be only single link failure, from the simultaneous failure of m_0 and m_1 we can unambiguously identify l_2. However, if dual link failures are also possible, then alarm code vector 110 could mean either the single failure of l_2 , or the dual link failure of l_0,l_3, or l_0,l_2 or l_2,l_3; thus, the alarm code is ambiguous in this case.

# Input
* Line 1: An integer links for the number of optical links.
* Line 2: An integer mtrails for the number of m-trails.
* Line 3: An integer failures for the maximum number of failures.
* Line 4: An mtrails-length strings containing zeros and ones for the alarm code vector.
* Next links lines: An mtrails-length string containing zeros and ones for the link code matrix.

# Output
* Link identifier k of the single failed link l_k, or the identifiers of the dual failed links in ascending order separated with a space (links are numbered from 0 to links-1). If the failure cannot be unambiguously identified, return AMBIGUOUS.
  
# Constraints
* 5 ≤ links ≤ 90
* 3 ≤ mtrails ≤ 20
* 1 ≤ failures ≤ 2
