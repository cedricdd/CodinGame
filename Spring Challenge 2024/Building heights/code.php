<?php

/**
 * @param int $n The number of buildings
 * @param (string)[] $buildingMap Representation of the n buildings
 * @return The height of each building.
 */
function buildingHeights($n, $buildingMap) {
    // Write your code here
    foreach($buildingMap as $building) $sizes[] = strlen(trim($building));
    return $sizes;
}

?>
