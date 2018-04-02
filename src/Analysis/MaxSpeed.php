<?php

declare(strict_types=1);

namespace App\Analysis;

/**
 * Class MaxSpeed.
 */
class MaxSpeed extends MetricAnalysis
{
    /**
     * Performs analysis on dataset and returns the max speed.
     *
     * @return mixed
     */
    public function analyse()
    {
        return $this->formatBits($this->metrics->max('value'));
    }
}
