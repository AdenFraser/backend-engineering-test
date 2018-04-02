<?php

declare(strict_types=1);

namespace App\Tests\Unit\Analysis;

use App\Analysis\MedianSpeed;

/**
 * Class MedianSpeedTest.
 */
class MedianSpeedTest extends MetricTestCase
{
    /**
     * Test Median is Returned.
     *
     * The default dataset for the MetricTestCase has 3 items, so the middle
     * item is used as the median.
     */
    public function testMedianIsReturnedFromSingleMiddleValue()
    {
        $analysis = new MedianSpeed(self::$dataset);

        $this->assertEquals(101.55, $analysis->result());
    }

    /**
     * Test Median is Returned.
     *
     * This tests the median for datasets with an even count of data -
     * the average of the two middle values is taken as the median in this instance.
     */
    public function testMedianIsReturnedFromTwoMiddleValues()
    {
        $dataset = self::$dataset;

        $dataset[] = [
            'metricValue' => 12771101.69,
            'dtime' => '2018-02-01',
        ];

        $analysis = new MedianSpeed($dataset);

        $this->assertEquals(101.67, $analysis->result());
    }
}
