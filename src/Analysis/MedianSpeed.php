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
        return $this->formatBits($this->determineMedian());
    }

    /**
     * Returns the Median - either the middle value or the average of two
     * middle values (when there is an even number of metric data).
     * 
     * @return float
     */
    private function determineMedian(): float
    {
        $count = $this->metrics->count();

        // Find the middle index, or the lowest middle index
        $middle = floor(($count - 1) / 2);

        // A middle value is available, return it as the median.
        if ($count % 2) {
            return $this->metrics->slice($middle, 1)->sum('value');
        }

        // Two middle values, return the average of the two as median.
        return $this->metrics->slice($middle, 2)->average('value');
    }
}
