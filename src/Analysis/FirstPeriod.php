<?php

declare(strict_types=1);

namespace App\Analysis;

/**
 * Class FirstPeriod.
 */
class FirstPeriod extends MetricAnalysis
{
    /**
     * Performs analysis on dataset and returns the first period's date.
     *
     * @return mixed
     */
    public function analyse()
    {
        return $this->metrics->first()['date']->format(self::PERIOD_FORMAT);
    }
}
