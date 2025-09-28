<?php


if(!function_exists('format_array_response')) {
    function format_array_response($originalArray) {

        
        $transformedArray = [];
        foreach ($originalArray as $key => $item) {
            $transformedArray[$key] = [
                'CARRIER'       => $item['name'],
                'SERVICE LEVEL' => $item['serviceLevel'],
                'RATE TYPE' => $item['rateType'],
                'TOTAL' => $item['total'],
                'TRANSIT TIME' => $item['serviceLevel'],
            ];
        }
    
        return $transformedArray;
    
    }
}

if(!function_exists('get_cheapest_rate')) {
    function get_cheapest_rate($originalArray) {

        $lowestPricesByServiceLevel= [];
        foreach ($originalArray as $key => $rates) {
            $level = $rates['SERVICE LEVEL'];
            $price = $rates['TOTAL'];

            if (!isset($lowestPricesByServiceLevel[$level]) || $price < $lowestPricesByServiceLevel[$level]) {
                $lowestPricesByServiceLevel[$level] = $price;
            }
        }

        $filteredArray = [];

        foreach ($originalArray as $item) {
            $level = $item['SERVICE LEVEL'];
            $value = $item['TOTAL'];

            if ($value == $lowestPricesByServiceLevel[$level]) {
                $filteredArray[] = $item;
            }
        }

        return $filteredArray;


    }
}