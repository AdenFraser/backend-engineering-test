<?php

declare(strict_types=1);

namespace App\Tests\Unit\Analysis;

use App\Analysis\SlowdownPeriods;

/**
 * Class SlowdownPeriodsTest.
 */
class SlowdownPeriodsTest extends MetricTestCase
{
    /**
     * Test the Slowdown Period is Returned.
     *
     * A slowdown period should be the start and end of a period of detected slowdown.
     *
     * The slowdown is determined by an standard deviation based outlier calculation. 
     */
    public function testSlowdownPeriodsAreReturned()
    {
        $fixture = file_get_contents(__DIR__.'/../../../resources/fixtures/2.json');

        $dataset = json_decode($fixture, true)['data'][0]['metricData'];

        $expectation = [
            [
                new \DateTime('2018-02-05'),
                new \DateTime('2018-02-07'),
            ]
        ];

        $analysis = new SlowdownPeriods($dataset);
        $actual = $analysis->result();

        $this->assertEquals($expectation, $actual);
    }

    /**
     * Test that an empty array is returned when no slowdowns.
     */
    public function testEmptyArrayWhenNoSlowdown()
    {
        $expectation = [];

        $analysis = new SlowdownPeriods(self::$dataset);
        $actual = $analysis->result();

        $this->assertEquals($expectation, $actual);
    }
}
