<?php

declare(strict_types=1);

namespace App\Analysis;

/**
 * Class SlowdownPeriods.
 */
class SlowdownPeriods extends MetricAnalysis
{
    /**
     * Standard Deviation Magnitude for Outlier Detection.
     */
    const MAGNITUDE = 1.7;

    /**
     * Performs analysis on dataset and returns an array of slowdown periods.
     *
     * @return array
     */
    public function analyse()
    {
        $periods = $this->determineOutlierPeriods();

        return collect($periods)
            // We only need the start and end of the periods.
            ->map(function ($period) {
                if (count($period) <= 2) {
                    return $period;
                }

                return [
                    reset($period),
                    end($period),
                ];
            })
            ->toArray();
    }

    /**
     * Determine Periods with Outliers.
     *
     * @todo Refactor this.
     *
     * @return array
     */
    private function determineOutlierPeriods(): array
    {
        $outliers = $this->filterOutliers();

        if (!count($outliers)) {
            return [];
        }

        $ranges = [];
        $currentRange = [];
        $lastDate = null;

        foreach ($outliers as $data) {
            $date = $data['date'];

            if (null === $lastDate) {
                $currentRange[] = $date;
            } else {
                $interval = $date->diff($lastDate);

                if ($interval->days === 1) {
                    // add this date to the current range
                    $currentRange[] = $date;
                } else {
                    // store the old range and start a new
                    $ranges[] = $currentRange;
                    $currentRange = array($date);
                }
            }

            // this date is now the last date
            $lastDate = $date;
        }

        $ranges[] = $currentRange;

        return $ranges;
    }

    /**
     * Returns an Array of Outliers.
     *
     * @todo Better code coverage required.
     *
     * @return array
     */
    private function filterOutliers(): array
    {
        $count = $this->metrics->count();
        $mean = $this->metrics->average('value');

        $fill = array_fill(0, $count, $mean);

        $data = $this->metrics->map(function ($data) {
            return $data['value'];
        })->toArray();

        $sdSquare = array_map(function ($x, $mean) {
            return pow($x - $mean, 2);
        }, $data, $fill);

        $deviation = sqrt(array_sum($sdSquare) / $count) * self::MAGNITUDE;

        return $this->metrics->reject(function ($data) use ($mean, $deviation) {
            // Return array of values that are outliers
            return $data['value'] <= $mean + $deviation && $data['value'] >= $mean - $deviation;
        })->toArray();
    }
}
