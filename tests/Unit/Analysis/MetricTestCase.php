<?php

declare(strict_types=1);

namespace App\Tests\Unit\Analysis;

use PHPUnit\Framework\TestCase;

/**
 * Class MetricTestCase.
 */
abstract class MetricTestCase extends TestCase
{
    /**
     * Example Dataset used by Unit Tests.
     *
     * @var array
     */
    protected static $dataset = [
        [
            'metricValue' => 12693166.98,
            'dtime' => '2018-01-29',
        ],
        [
            'metricValue' => 12668239.57,
            'dtime' => '2018-01-30',
        ],
        [
            'metricValue' => 12723772.1,
            'dtime' => '2018-01-31',
        ],
    ];
}
