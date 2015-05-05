<?php

class static_weight {

    public function compute($vector) {
        $sum = 0;
        foreach ($vector as $entry)
            $sum = $sum + $entry; 
        return $sum;
    }
}
