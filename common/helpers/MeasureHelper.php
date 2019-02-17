<?php

namespace common\helpers;

class MeasureHelper {

    CONST MEASURE_RELATION = [
        "cold" => 'm3',
        "hot" => 'm3',
        "gas" => 'm3',
        "heat" => 'Gcal',
        "power" => 'kWh',
        "current" => 'blank-string',
        "voltage" => 'A',
        "cos_fi" => 'V'
    ];

    public static function validate($measureUnit, $measureItem) {
        if (self::MEASURE_RELATION[$measureUnit] == $measureItem) {
            return true;
        }
        return false;
    }

}
