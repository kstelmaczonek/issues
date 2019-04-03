<?php

namespace Issue;

use Issue\Nbp\Webservice;
use Issue\Nbp\Configuration;
use function BenTools\CartesianProduct\cartesian_product;

final class App
{
    public static function run()
    {
        $ws = new Webservice(new Configuration);
        $response = $ws->getByDateRange('2018-04-01', '2019-04-01');
        $formatted = $ws->formatResponse($response);

        $chosenValue = 0;
        $chosenPeriod = [];
        foreach (cartesian_product([$formatted, $formatted]) as $combination) {
            $firstDate = key($combination[0]);
            $secondDate = key($combination[1]);
            $firstValue = $combination[0][$firstDate];
            $secondValue = $combination[1][$secondDate];
            $substract = round($firstValue - $secondValue, 2);
            
            if ($substract > 0 && $substract > $chosenValue) {
                $chosenValue = $substract;        
                $chosenPeriod[0] = $firstDate;
                $chosenPeriod[1] = $secondDate;       
            }
        }
        
        $period = [strtotime($chosenPeriod[0]), strtotime($chosenPeriod[1])];
        sort($period);
        return sprintf(
            'Z tego okresu należało kupić %s i sprzedać %s aby zarobić %s',
            date('Y-m-d', $period[0]),
            date('Y-m-d', $period[1]),
            $chosenValue
        );    
    }
}
