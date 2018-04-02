<?php

declare(strict_types=1);

namespace App\Analysis;

/**
 * Class MinSpeed.
 */
class MinSpeed extends MetricAnalysis
{
    /**
     * Performs analysis on dataset and returns the min speed.
     *
     * @return mixed
     */
    public function analyse()
    {
        return $this->formatBits($this->metrics->min('value'));
    }
}
