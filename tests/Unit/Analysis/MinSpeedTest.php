<?php

declare(strict_types=1);

namespace App\Tests\Unit\Analysis;

use App\Analysis\MinSpeed;

/**
 * Class MinSpeedTest.
 */
class MinSpeedTest extends MetricTestCase
{
    /**
     * Test Min is Returned.
     */
    public function testMinIsReturned()
    {
        $analysis = new MinSpeed(self::$dataset);

        $this->assertEquals(101.35, $analysis->result());
    }
}
