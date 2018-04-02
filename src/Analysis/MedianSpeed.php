<?php

declare(strict_types=1);

namespace App\Analysis;

/**
 * Class MedianSpeed.
 */
class MedianSpeed extends MetricAnalysis
{
    /**
     * Performs analysis on dataset and returns the median speed.
     *
     * @return mixed
     */
    public function analyse()
    {
        return $this->formatBits($this->metrics->median('value'));
    }
}
