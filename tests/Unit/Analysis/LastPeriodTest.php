<?php

declare(strict_types=1);

namespace App\Tests\Unit\Analysis;

use App\Analysis\LastPeriod;

/**
 * Class LastPeriodTest.
 */
class LastPeriodTest extends MetricTestCase
{
    /**
     * Test Last Period is Returned.
     */
    public function testLastPeriodIsReturned()
    {
        $analysis = new LastPeriod(self::$dataset);

        $this->assertEquals('2018-01-31', $analysis->result());
    }
}
