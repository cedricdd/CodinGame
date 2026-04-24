<?php

$rules = [];

fscanf(STDIN, "%d", $conditionalRuleCount);
for ($i = 0; $i < $conditionalRuleCount; $i++) {
    fscanf(STDIN, "%s %s %d %s %d", $conditionalRuleQuantity, $conditionalRuleOperator, $conditionalRuleValue, $conditionalRuleCostType, $conditionalRuleCost);

    $rules[] = [ucfirst($conditionalRuleQuantity), $conditionalRuleOperator, $conditionalRuleValue, $conditionalRuleCostType, $conditionalRuleCost];
}


fscanf(STDIN, "%s %s %d", $defaultRuleQuantity, $defaultRuleCostType, $defaultRuleCost);

fscanf(STDIN, "%d", $orderCount);

for ($i = 0; $i < $orderCount; $i++) {
    fscanf(STDIN, "%d %d %d", $orderPallets, $orderParcels, $orderKg);

    //Check all rules
    foreach($rules as [$conditionalRuleQuantity, $conditionalRuleOperator, $conditionalRuleValue, $conditionalRuleCostType, $conditionalRuleCost]) {
        if(eval("return " . ${"order" . $conditionalRuleQuantity} . " " . $conditionalRuleOperator . " " . $conditionalRuleValue . ";")) {
            echo $conditionalRuleCost * ($conditionalRuleCostType == "fixed" ? 1 : ${"order" . $conditionalRuleQuantity}) . PHP_EOL;
            continue 2;
        }
    }

    //No rule applies, default one
    echo $defaultRuleCost * ($defaultRuleCostType == "fixed" ? 1 : ${"order" . ucfirst($defaultRuleQuantity)}) . PHP_EOL;
}
