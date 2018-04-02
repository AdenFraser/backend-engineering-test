<?php

declare(strict_types=1);

namespace App\Tests\Unit\Analysis;

use App\Analysis\AverageSpeed;

/**
 * Class AverageSpeedTest.
 */
class AverageSpeedTest extends MetricTestCase
{
    /**
     * Test Average is Returned.
     */
    public function testAverageIsReturned()
    {
        $analysis = new AverageSpeed(self::$dataset);

        $this->assertEquals(101.56, $analysis->result());
    }
}
