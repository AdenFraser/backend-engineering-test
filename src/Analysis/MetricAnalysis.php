<?php

declare(strict_types=1);

namespace App\Analysis;

use Tightenco\Collect\Support\Collection;

/**
 * Class MetricAnalysis.
 */
abstract class MetricAnalysis
{
    /**
     * Period Date Format.
     */
    const PERIOD_FORMAT = 'Y-m-d';

    /**
     * Collection of Metrics Data.
     *
     * @var \Tightenco\Collect\Support\Collection
     */
    protected $metrics;

    /**
     * Instantiate the Metric Analysis class with the dataset provided.
     * 
     * @param array $dataset 
     */
    public function __construct(array $dataset)
    {
        $this->setDataset($dataset);
    }

    /**
     * Returns the result of an Analysis. 
     *
     * This is method is currently just an alias for `analyse` but provides an
     * opportunity to perform additional setup tasks post-construct but
     * prior to the analyse method on the child class being called.
     * 
     * @return mixed
     */
    public function result()
    {
        return $this->analyse();
    }

    /**
     * Perform Metric Analysis.
     *
     * @return mixed
     */
    abstract public function analyse();

    /**
     * Set Dataset for this Metric Analysis.
     * 
     * @param array $dataset
     */
    protected function setDataset(array $dataset)
    {
        $this->metrics = collect($dataset)
            // Map through the daily data and format slightly nicer.
            ->map(function($day) {
                return [
                    'date' => new \DateTime($day['dtime']),
                    'value' => $day['metricValue'],
                ];
            });
    }

    /**
     * Format bytes to megabits.
     *
     * @todo This should work with different units.
     *
     * @return float
     */
    protected function formatBits($bytes, $precision = 2): float
    {
        return round($bytes * 8 / 1000 / 1000, 2);
    } 
}
