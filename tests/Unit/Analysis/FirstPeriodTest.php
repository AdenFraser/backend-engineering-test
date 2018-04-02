<?php

declare(strict_types=1);

namespace App\Tests\Unit\Analysis;

use App\Analysis\FirstPeriod;

/**
 * Class FirstPeriodTest.
 */
class FirstPeriodTest extends MetricTestCase
{
    /**
     * Test First Period is Returned.
     */
    public function testFirstPeriodIsReturned()
    {
        $analysis = new FirstPeriod(self::$dataset);

        $this->assertEquals('2018-01-29', $analysis->result());
    }
}
