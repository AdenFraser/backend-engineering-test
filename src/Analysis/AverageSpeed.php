<?php

declare(strict_types=1);

namespace App\Analysis;

/**
 * Class AverageSpeed.
 */
class AverageSpeed extends MetricAnalysis
{
    /**
     * Performs analysis on dataset and returns the average speed.
     *
     * @return mixed
     */
    public function analyse()
    {
        return $this->formatBits($this->metrics->average('value'));
    }
}
