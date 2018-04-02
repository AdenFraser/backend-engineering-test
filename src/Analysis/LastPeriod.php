<?php

declare(strict_types=1);

namespace App\Analysis;

/**
 * Class LastPeriod.
 */
class LastPeriod extends MetricAnalysis
{
    /**
     * Performs analysis on dataset and returns the last period's date.
     *
     * @return mixed
     */
    public function analyse()
    {
        return $this->metrics->last()['date']->format(self::PERIOD_FORMAT);
    }
}
